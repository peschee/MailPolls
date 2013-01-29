#MailPolls
A very simple, dumb and lightweight project to create polls which can be used in emails and newsletters.
 
 * Creates individual links for each poll option in the following format:<br>
 `http://your-url.com/your-poll-directory/?o=2&s=aSecretHash`

 * Let's you create new polls and options in `/backend`.
 
## Installation
 * Set up a database and import `installation/db.sql`. It's recommended to not upload installation folder to your live server.
 * Rename or copy `config.dist.php` to `config.php` and update to your settings.
 * Password protect `/backend`-folder.
 * Add poll and options to database.
 * Go to backend and find option links to use in your email.
 * Get started!

## Known limitations
 * Editing polls is only possible in the database.

## Author
Manuel Reinhard <manu@sprain.ch>
 