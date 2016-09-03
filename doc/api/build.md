# bitsquare application APIs

This directory and sub-directory contain the documentation for bitsquare
(java app) APIs.

Each sub-directory represents a single API method, and contains a file named
apidoc.php that contains a class api_<method>.

The index.php file loads all the api classes, queries them, and constructs a
formatted documentation page with the results.  Two output files are
generated: index.html and api.md

The command to build both output files is:

./build.sh

github does not render html files unless checked into a special branch.
The index.html can be viewed using rawgit at:

    https://rawgit.com/dan-da/bitsquare/rpc_api/doc/api/index.html
    