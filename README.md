# RMIS: A risk management system

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
## Description
RMIS is a risk management system designed for financial organizations to track risks and record new ones.
Some of the features are:
- **Dashboard**: View the summary of risks based on severity, status, and categories. 
- **Risk register**: List of risks registered.
- **Collaborators**: Users that can edit or update a risk and add incidents on that risk.
- **Comment section**: A note/comment section of a risk.
- **Incident reporting**: A risk can have multiple risks and they can be reported and viewed within the risk.
- **Search and filter**: Search using key words or filter using status, category or severity. 
- **Role-based status update**: Status can be updated only by creator of risk or higher level manager. 
- **Admin-based registration**: Admin approval required for registration. 
- **On system and email notification**: Admin notified when a new user requests approval, and user notified on the response from Admin.

## Demo
<img width="3804" height="2095" alt="Dashboard" src="https://github.com/user-attachments/assets/f1f049d8-5a43-4fe6-a40b-3397d610b96c" />
<img width="3824" height="2102" alt="Registered risks" src="https://github.com/user-attachments/assets/08e38114-e2a1-4fea-bce7-30a3881ad4e4" />
<img width="3805" height="2102" alt="Admin portal for user management" src="https://github.com/user-attachments/assets/e19e6723-d189-42fe-8954-b0b3484bb266" />
<img width="3800" height="2097" alt="Risk Detatiled view 1" src="https://github.com/user-attachments/assets/8dfd7754-98b0-4efb-a77c-d79cab327e41" />
<img width="3798" height="2100" alt="Risk Detailed view 2" src="https://github.com/user-attachments/assets/4745b85d-6781-4a8c-b7c9-f9881b6a09de" />
<img width="3804" height="2098" alt="Risk Detailed view 3" src="https://github.com/user-attachments/assets/ca2f0554-3eca-48d0-b895-caf82867c3aa" />
<img width="3839" height="2085" alt="Incident view" src="https://github.com/user-attachments/assets/c2e7fa39-2a8e-4924-89af-4608a073bd4c" />

## Prerequisites
- PHP (>= 8.2)
- Composer
- Laravel (>= 9.0)
- A database (e.g., MySQL)
- Node.js


## Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/estif34/rmis2.git
   cd rmis2
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   npm run dev
   ```
3. Set up the environment:
   ```bash
   copy .env.example .env
   ```
   - Configure the .env file with your database and application settings.

4. Generate the application key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations to set up the database:
   ```bash
   php artisan migrate
   ```
6. Start the development server:
   ```bash
   php artisan serve
   ```
7. Access the application at http://127.0.0.1:8000
