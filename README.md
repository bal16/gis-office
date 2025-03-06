# Geographic Information System: Kantor Kelurahan dan Kecamatan Kota Semarang

This project is a **Geographic Information System (GIS)** for displaying and managing the locations of **Kantor Kelurahan** (sub-district offices) and **Kantor Kecamatan** (district offices) in **Kota Semarang**. The application is built using modern web technologies including **Laravel**, **Filament**, **Leaflet.js**, and **Tailwind CSS**.

## Features

- **Single Page Application (SPA)**:  
  Seamlessly navigate between pages to index and search for offices without page refreshes.

- **Interactive Map**:  
  Use **Leaflet.js** to visually explore the locations of Kelurahan and Kecamatan offices on an interactive map.

- **Office Management**:  
  Easily manage and update office information such as name, district, latitude, longitude, and office images.

- **Responsive UI**:  
  Built with **Tailwind CSS** to ensure a mobile-first, responsive design that works across various devices.

- **Admin Panel**:  
  Utilize the **Filament Admin Panel** to allow administrators to manage office data and map information with ease.

- **Localization Support**:  
  Multilingual support for **English** and **Indonesian (ID)**.

  
## Routes
- `/` : The home page displaying the table and office search.
- `/admin` : Admin panel for managing office data and settings.
- `/api` : API endpoints for accessing office data programmatically.

## Technologies Used

- **Laravel**: The backend framework used to build and handle API endpoints, database connections, and application logic.
- **Filament**: A Laravel-based admin panel for managing office data, providing an easy-to-use interface for CRUD (Create, Read, Update, Delete) operations.
- **Leaflet.js**: A JavaScript library used to create the interactive maps and display office locations based on latitude and longitude data.
- **Tailwind CSS**: A utility-first CSS framework used to style the user interface with a focus on simplicity and responsiveness.

## Installation

### Requirements

- PHP >= 8.3
- Composer
- Node.js >= 18:lts (for compiling assets)
- SQLite, MySQL, or another database of your choice

### Steps

1. Clone the repository:

   ```bash
   git clone https://github.com/bal16/gis-office.git
   ```

2. Navigate to the project directory:

    ```bash
    cd gis-office
    ```
3. Install the PHP dependencies:

4. composer install

5. Copy the example environment file:

    ```bash
    cp .env.example .env
    ```

6. Generate the application key:

    ```bash
    php artisan key:generate
    ```
7. Configure your .env file with your database and other application settings.

8. Run database migrations and seed the database:

    ```bash
    php artisan migrate --seed
    ```
9. Install JavaScript dependencies:

    ```bash
    npm install
    ```
10. Link the storage assets:

    ```bash 
    php artisan storage:link
    ```
11. Start the development server:

    ```bash 
    composer run dev
    ```

12. The application should now be running on http://localhost:8000.

#### For Production Deployment:
11. Run asset builder:
    
    ```bash
    npm run build
    ```
12. Start the Queue worker
    
    ```bash
    php artisan queue:work
    ```
13. Routes the Requests of your php server to /public/index.php
14. The application should now accessed on your server

## Acknowledgements

- Laravel: https://laravel.com/
- Filament: https://filamentadmin.com/
- Leaflet.js: https://leafletjs.com/
- Tailwind CSS: https://tailwindcss.com/

## See also

* [LARAVEL.md](LARAVEL.md): For additional information and configuration related to the Laravel framework used in this project.

