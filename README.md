# Todo App

## Brief

In this project, I made a simplified laravel To-do application that has many features to demonstrate, such as:

-   Public & Private Real-time notifications (Websockets) using Laravel Pusher and Echo
-   RESTful API using Laravel Sanctum
-   Caching and Observer
-   Middleware
-   Login/registration system using Laravel Auth scaffolding
-   Frontend compilation using vite
-   Administrative features (on tasks)
-   CRUD operations

In this application, only the admin can create, edit, or delete the tasks in the to-do list, while users can only view them.
When the admin creates, updates, or deletes a task, all subscribers should receive a real-time notification with a message about the operation the admin has performed.
The notification also has a reload icon for the users to see the up-to-date todo list.

On the other hand, the admin can view the current registered users, and send them a real-time private message.

When the admin logs in, they should be automatically redirected to /admin page, while other users should be redirected to /home page.

## Table of Contents

-   [Getting Started](#getting-started)
    -   [Prerequisites](#prerequisites)
    -   [Installation](#installation)
-   [Usage](#usage)
-   [Contributing](#contributing)

## Getting Started

These instructions will help you clone and set up the project on your local machine for development and testing purposes.

### Prerequisites

-   [Git](https://git-scm.com/) (optional)
-   [Node.js](https://nodejs.org/) (npm included)
-   [Composer](https://getcomposer.org/)
-   [Postman](https://www.postman.com/downloads/) (or any API client)
-   [Local development server such as MAMP or XAMPP](https://www.mamp.info/en/downloads/)

### Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/Mohammad271091/extensya-todo.git
    ```

2. Navigate to the project folder and copy the .env file sent with the email
3. Create a database on your local machine and name it "todos" _or any other name, but make sure to change it accordingly in the .env file along with username and password_
4. Install composer packages

    ```
    composer install
    ```
5. Install npm packages
    ```
    npm install
    ```    
6. Migrate the database tables
    ```
    php artisan migrate
    ```
7. Run the seeder commands for users and tasks tables
    ```
    php artisan db:seed --class=UserSeeder
    ```        
    and
    ```
    php artisan db:seed --class=TaskSeeder
    ```
8. Start the artisan server
    ```
    php artisan serve
    ```    
9. Start the vite server    
    ```
    npm run dev
    ```

## Usage
The following users are seeded to the database and can be directly used:
    -   [email: **mohammad@gmail.com** with password: **password1234** (admin)]
    -   [email: **sara@gmail.com** with password: **password1234** (normal user)]

    *Note: all other users in the database have the password **password1234** *

