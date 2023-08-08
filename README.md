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
    - [Users](#users)
    - [Dashboards](#dashboards)
-   [RESTful API](#restful-api)
    - [Login](#login)
    - [Endpoints](#endpoints)
-   [Caching](#caching)    
-   [Next Step](#next-step)    

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

## Users

The following users are seeded to the database and can be directly used:

-   email: **mohammad@gmail.com** with password: **password1234** (admin)
-   email: **sara@gmail.com** with password: **password1234** (normal user)

*   Note: all other users in the database have the password **password1234**

## Dashboards

At login, the admin would be redirected to /admin page where he can add new tasks, update existing tasks, or delete them.
The admin can also view all current users and send them real-time and **private** messages/notifications.

On the other hand, the normal user can only view the tasks, and should receive notifications corresponding to the CRUD operations by the admin, and also receive private messages if sent to them by the admin.

_Note: the notification has a reload icon for the page to refresh and view the up to date changes_

## RESTful API

This API uses sanctum for managing authentication and endpoints.
Only the admin can add new tasks, delete tasks, and update existing ones.
While all the users can view all the tasks, or view a specific task.

## Login
- Open Postman (or your preferred API client)
- The user (either admin or normal user) should login in order to access the api endpoints (*replace localhost:8000 with your local server address, this applies to all endpoints*)
- Use the below endpoint to login with a **POST** request
    ```
    localhost:8000/api/tasks/login
    ```
- In the **Body** tab, under **x-www-form-urlencoded** write your email and password (example: mohammad@gmail.com, password1234 to login as an admin)     
- Now, you'll receive your API token as a response, copy it in order to use it with all your next API calls.
### Endpoints

First step you need to do is to add your API token, open the **Authorization** tab, choose **Bearer Token**, and add paste your token there.

+ to create a new task, use the following endpoint with a **POST** request and after adding the **task** and **description** in the request body.

```
localhost:8000/api/tasks/create
```
example: 

key: task ========> value: solve the homework

key: description ========> value: this is a daily todo task


+ to delete a task, use the following endpoint with a **DELETE** request
```
localhost:8000/api/tasks/delete/{taskID}
```

example: localhost:8000/api/tasks/delete/1 (this will delete the task with ID: 1)


+ to update an existing task, use the following endpoint with a **PUT** request and after filling the task and description in the request body similar to the create endpoint
```
localhost:8000/api/tasks/update/{taskID}
```

example: localhost:8000/api/tasks/update/2 (this will update the task with ID: 2 with the newly filled data (task and description))


+ to view a specific task, use the following endpoint with a **GET** request
```
    localhost:8000/api/tasks/view/{taskID}
```

example: localhost:8000/api/tasks/view/10 (this will view the task with ID: 10)


+ to view all tasks, use the following endpoint with a **GET** request
```
    localhost:8000/api/tasks
```

## Caching
In this project I've used the default laravel caching driver which is file caching.
Caching here is used along with Laravel Observer in the following way:

The user will fetch the to-do list from the server for the first time, and then it will be cached for 24hrs **unless** the admin adds a new task, updates an existing task, or deletes a task; in this case
the cache will be deleted, and the process repeats.

This applies for both the web and the API calls, but it is not applied on the admin web page.


## Next Step
This project is only meant to be a simplified demonstration for specific features, for example the following can be added to the project to make it more efficient:
- Redis in-memory caching instead of the default file driver, which makes the website faster, more efficient, and more optimized
- More optimized queries to the database, for example using query builder instead of Eloquent in some cases might be faster
- Adding relations to add the functionality of each user to manage their own to-do tasks
- Using Laravel resources with API endpoints to gain more control over them
- Using token methods in the API controller to check for the token **abilities** "that for some reason didn't work for me" instead of using Auth facade to check for the signed in user/token
- Using Rate Limiter to throttle frequent requests to the open endpoints

