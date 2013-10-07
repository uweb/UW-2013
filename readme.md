# UW 2013

UW branded Wordpress theme by the UW Web Team.

### Javascript Development

The javascript is developed using Grunt. 
Here's how to install and start developing (mac):

Using a package manager like Homebrew, install npm and node.js

    brew install npm

Then install Grunt through npm globally

    npm install -g grunt
    
Clone/download the UW 2013 theme and change into its root directory

    git clone https://github.com/uweb/UW-2013.git ~/directory/to/uw-2013/theme/
    cd ~/directory/to/uw-2013/theme/
    
Once in the theme directory, install the node dependencies

    npm install 

Once that's done run the following command. 
Now every file defined by Gruntfile.js will trigger concatenating and minifying the javascript files.

    grunt watch

