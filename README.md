# Todo App

## Brief
In this project, I made a simplified laravel To-do application that has many features to demonstrate, such as: 
- Public & Private Real-time notifications (Websockets) using Laravel Pusher and Echo
- RESTful API using Laravel Sanctum
- Caching and Observer
- Middleware
- Login/registration system using Laravel Auth scaffolding
- Frontend compilation using vite
- Administrative features (on tasks)
- CRUD operations

In this application, only the admin can create, edit, or delete the to-do tasks, while users can only view them.
When the admin creates, updates, or deletes a task, all subscribers should receive a real-time notification with a message about the operation the admin has performed.
The notification also has a reload icon for the users to see the up-to-date todo list.

## Table of Contents

- [Getting Started](#getting-started)
  - [Prerequisites](#prerequisites)
  - [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)

## Getting Started

These instructions will help you clone and set up the project on your local machine for development and testing purposes.

### Prerequisites

- [Git](https://git-scm.com/)
- [Node.js](https://nodejs.org/) (npm included)
- [Composer](https://getcomposer.org/)

### Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/your-repo.git
   cd your-repo
   

