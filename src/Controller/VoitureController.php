<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class VoitureController extends AbstractController
{
    /**
     * @Route("/api/voitures", methods={"POST"})
     */
    public function create(
        Request $request, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator,
        VoitureRepository $repository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['model']) || !isset($data['kmh'])) {
            return $this->json(['error' => 'Model and Km/h are required fields.'], 400);
        }
        if (!is_numeric($data['kmh'])) {
            return $this->json(['error' => 'Km/h must be a valid number.'], 400);
        }
        $existingVoiture = $repository->findOneBy([
            'model' => $data['model'],
            'kmh' => $data['kmh']
        ]);
    
        if ($existingVoiture) {
            return $this->json(['error' => 'A car with this model and speed already exists.'], 409);
        }

        $voiture = new Voiture();
        $voiture->setModel($data['model'])
                ->setKmh($data['kmh'])
                ->setCaracteristiques($data['caracteristiques'] ?? []);

        // Validation
        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $em->persist($voiture);
        $em->flush();

        return $this->json($voiture, 201);
    }

    /**
     * @Route("/api/voitures", methods={"GET"})
     */
    public function list(VoitureRepository $repository): JsonResponse
    {
        $voitures = $repository->findAll();
        return $this->json($voitures);
    }

    /**
     * @Route("/api/voitures/{id}", methods={"PUT"})
     */
    public function update(
        int $id, 
        Request $request, 
        VoitureRepository $repository, 
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $voiture = $repository->find($id);
        if (!$voiture) {
            return $this->json(['error' => 'Voiture non trouvée'], 404);
        }

        $data = json_decode($request->getContent(), true);

        if (!is_numeric($data['kmh'])) {
            return $this->json(['error' => 'Km/h must be a valid number.'], 400);
        }
        $voiture->setModel($data['model'])
                ->setKmh($data['kmh'])
                ->setCaracteristiques($data['caracteristiques'] ?? []);

        // Validation
        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $em->flush();
        return $this->json($voiture);
    }

    /**
     * @Route("/api/voitures/{id}", methods={"DELETE"})
     */
    public function delete(
        int $id, 
        VoitureRepository $repository, 
        EntityManagerInterface $em
    ): JsonResponse {
        $voiture = $repository->find($id);
        if (!$voiture) {
            return $this->json(['error' => 'Voiture non trouvée'], 404);
        }

        $em->remove($voiture);
        $em->flush();

        return $this->json(null, 204);
    }

/**
 * @Route("/api/calculer-temps", methods={"POST"})
 */
public function calculerTemps(Request $request, VoitureRepository $repository): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    // Validation des paramètres
    if (!isset($data['distance']) || !isset($data['model'])) {
        return $this->json([
            'error' => 'Les paramètres distance et model sont requis'
        ], 400);
    }

    $voiture = $repository->findOneBy(['model' => $data['model']]);
    if (!$voiture) {
        return $this->json(['error' => 'Voiture non trouvée'], 404);
    }

    // Calcul du temps
    $temps = $data['distance'] / $voiture->getKmh();

    return $this->json([
        'distance' => $data['distance'],
        'model' => $voiture->getModel(),
        'vitesse' => $voiture->getKmh(),
        'temps' => round($temps, 2) . ' heures'
    ]);
}
}

