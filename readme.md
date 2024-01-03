# Getting Started

### FRONTEND

1. change the "config.js" SERVER_PATH to the correct path to the backend server

2. run the website ("index.html") on a local server (i used IntelliJ) to not get blocked by CORS

### BACKEND

1. in PHP configuration files, enable:

- extension=mysqli
- extension=curl
- include_path=".;c:\php\includes" (for Windows)
- include_path=".:/php/includes" (for Unix)

2. in "config.php" update the "$CERTIFICATION_URL"

3. run "initialize.php" to initialize the database with dummy data

4. open "backend" folder in terminal and run: "php -S localhost:8000" to run the server locally

### DATABASE

1. create connection (or change the values in the "config.php" file):

- host: 127.0.0.1:3306
- username: media_supreme
- password: 1234
- database: leads_db

2. run "initialize_db.sql" commands in MySQL, to create the required database and tables
