Symfony Project Setup Guide
This guide provides step-by-step instructions to set up and run your Symfony project locally. Follow these steps to get your application up and running.

Prerequisites
Ensure your development environment meets the following requirements:

PHP Version: PHP 8.2 or higher.
PHP Extensions: Ctype, iconv, PCRE, Session, SimpleXML, and Tokenizer.
Composer: Dependency management tool for PHP.
For detailed installation instructions, refer to the Symfony Setup Documentation.

Installation Steps
Clone the Repository

Clone the project repository to your local machine:

bash
Copy
Edit
git clone https://github.com/your-username/your-symfony-project.git
cd your-symfony-project
Install Dependencies

Use Composer to install the project's dependencies:

bash
Copy
Edit
composer install

Install the Doctrine ORM and MakerBundle:

bash
Copy
Edit
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
Configure the Database Connection

In your .env file, set the DATABASE_URL to match your MySQL credentials:

ini
Copy
Edit
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.37"
Replace db_user, db_password, and db_name with your actual MySQL username, password, and database name.

If your MySQL server uses a Unix socket (common on macOS with MAMP), add the unix_socket parameter:

ini
Copy
Edit
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.37&unix_socket=/path/to/mysql.sock"
Replace /path/to/mysql.sock with the actual path to your MySQL socket file.

For example, on macOS with MAMP, the socket path might be /Applications/MAMP/tmp/mysql/mysql.sock.

For more details, refer to the Symfony documentation on Databases and the Doctrine ORM.


Set Up Environment Variables

Copy the example environment file and edit it as needed:

bash
Copy
Edit
cp .env.example .env
Update the .env file with your database and other service configurations.

Create the Database

Create the database using Symfony's console command:

bash
Copy
Edit
php bin/console doctrine:database:create
Run Migrations

Apply database migrations to set up the schema:

bash
Copy
Edit
php bin/console doctrine:migrations:migrate
Start the Development Server

Start the Symfony development server:

bash
Copy
Edit
symfony server:start
By default, the server runs at http://127.0.0.1:8000.

Note: The Symfony CLI tool is recommended for local development. If you don't have it installed, you can download it from the Symfony website. Alternatively, you can use a web server like Nginx or Apache to run the application.