# zDL
---

zDL is a small framework that allows you to generate download links for the files placed on your server.
You just have to set downloads you want and get corresponding download links, zDL will manage your downloads.

## Requirements

- PHP version 5.4.0
- `.htaccess` support *(non-essential, but highly recommended)*

## Installation

1. Put the **zDL** folder anywhere in your website directory.
2. Include the **init** file where you want to generate downloads, like this: `require('path/to/zDL/init');`

That's all! Now you can generate your downloads. Read the API section to know how to do this.

## API reference

*Use these methods to configure and generate downloads in your code.*

*A zDL instance is already created by the init file, so use directly the methods on this object.*

---

- `download( $downloadName, $filename )` > used to create a new download and register it

	* `{string} downloadName` - the download name
	* `{string} filename` - path to the desired file
	
---
	
- `getLink( $downloadName )` > call this method to get a download link, specified by the download name
	* `{string} downloadName` - the download name

---

## Licence

Project distributed under [GPL](http://en.wikipedia.org/wiki/GNU_General_Public_License) licence. For more details read LICENCE.txt.

## More …

New functionalities will be added to this framework in the future.
