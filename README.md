# webpad
------

Webpad is a basic implementation of the standard minimalist online notepad à la notepad.cc, pastebin, et al.  It was 
designed to be as easy as possible to set up on a LAMP server and deployable to any part of the server.  All it really needs 
is a bit of PHP, a few AJAX calls, and a Linux filesystem. 

Changes to the text field are detected at regular intervals and written out to a file based on the address the app was accessed 
at.  If no file is specified, the app redirects to a random set of lowercase letters.

Installation
--------------

1. Extract to a web server that has PHP <=5.2
2. Ensure write permission is given to ./_tmp (data is stored on files here)

License
------

MIT     
