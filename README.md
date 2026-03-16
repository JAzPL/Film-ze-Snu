# Film-ze-Snu

Film ze Snu is a fully multilingual web application written in PHP that transforms a user's dream description into a short multimedia film using artificial intelligence. The application uses Pollinations AI — a free AI platform with access to many models.
<br><br>
Open konfiguracja/klucz_api.php and insert your API key:
<br><br>
konfiguracja/klucz_api.php
<?php
return [
    'klucz'    => 'sk_TWOJ_KLUCZ_API_TUTAJ', // API Pollinations
    'baza_url' => 'https://gen.pollinations.ai',
];
<br><br>
Folder permissions
The projekty/ folder must be writable by the web server:
<br><br>
bash
mkdir -p projekty
chmod 755 projekty
# Lub na niektorych serwerach:
chmod 777 projekty
<br><br>
<br>
Server configuration<br>
Apache: ensure mod_rewrite is enabled and AllowOverride All is set for the directory.
<br><br>
.htaccess (Apache)
# Wymagane dla mod_rewrite
Options -Indexes<br>
AllowOverride All<br>
Nginx: add try_files $uri $uri/ /index.php?$query_string; to your vhost configuration.
<br><br>
nginx.conf
location / {
    try_files $uri $uri/ /index.php?$query_string;
}



<br><br><br>
The file konfiguracja/modele.php defines which AI models are used for each task. The script automatically picks a random model from the "best" list — ensuring varied results every time.
<br><br>
The application supports an unlimited number of languages. Simply add a new PHP file to the jezyk/ directory — everything else happens automatically.
<br><br>
AI automatically creates the screenplay and narration in the user's language. If the user writes in English — AI will respond in English and generate the voice narration in English as well.
<br><br>
Generation proceeds step by step, with each step as a separate AJAX request. This allows the interface to update the progress bar in real time.

