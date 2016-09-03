# bitsquare application APIs

This directory and sub-directory contain the documentation for bitsquare
(java app) APIs.

Each sub-directory represents a single API method, and contains a file named
apidoc.php that contains a class api_<method>.

The index.php file loads all the api classes, queries them, and constructs a
formatted documentation page with the results.

The index.html file is generated from index.php with the following command:

    php index.php > index.html

The api.md file is generated from index.php with:

    php index.php -f markdown > api.md
