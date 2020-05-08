########################################
## Run the following to copy the env file & generate key
cp .env.example .env
php artisan key:generate

########################################
## Run the following to have a fresh copy of the DB
php artisan migrate:fresh --seed

########################################
## Run to create a link to storage folder
php artisan storage:link

########################################
## Run the following to generate the Passport Key
php artisan passport:keys 
php artisan passport:client --personal

########################################
## Sequence of API to be called for Registration of user. 
POST api/register
	- Parameter required => name, email, password, password_confirmation
	- Optional parameter => profile_picture
	- Get the email/resend url from email sent for next step

GET email/resend 
	- header use => application/json
	
GET email/verify

POST api/login
	- Parameter required => email address, password

POST articles/create

########################################
## Sequence of API to be called to reset password 
POST api/password/email
	- Parameter required => email
	- Get the token from the email sent for next step

POST api/password/reset
	- Parameter required => email, token, password, password_confirmation

########################################
## Public API without login required
GET api/articles
GET api/articles/{article_id}