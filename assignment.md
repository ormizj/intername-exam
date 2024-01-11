#### Description:

You are Vasya, a web developer for a media company called
“Media Supreme“ and you are tasked with creating a landing page for the company that saves the clients details in order to call them back.

**Please write performant, understandable and documented code, take security measures, and good luck.**

#### Technologies:

PHP, Javascript, HTML, CSS, MySQL

#### Database:

create a new database scheme called “ leads_db “, with a table called “leads”.
The table should have the following fields columns, with appropriate typing:

- id
- first name
- last name
- email
- phone number
- ip - ip address of user
- country - country name ex. `Israel`
- url - full uri with query string
- note - free text
- sub_1 - free text
- called
- created_at

#### Backend:

create leads.php file with the following functionality, separate each functionality with a dedicated function.

- Add Leads to the Database.
- Show Lead details by id.
- Edit Lead by id to mark a lead as “called” lead.
- Prepare queries to show all leads that are “called”, filtered by created today, filtered by country (3 filters altogether).

Using the JSON resource, use CURL to receive a list of users, to fill the database with Leads, for info that doesn’t exist, create random fake details.
