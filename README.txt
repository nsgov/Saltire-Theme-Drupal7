Author: Communications Nova Scotia (commtech@novascotia.ca)

Last Updated: December 30th, 2014 by Allan Lawlor.

Nova Scotia "Saltire" look and feel, Drupal Theme for Drupal 7.x


-----------------------------------------------------------------------

TO INSTALL:

1.	Upload this folder and its contents into /sites/all/themes
2.	Enable and set as Default under /admin/build/themes

-----------------------------------------------------------------------

DRUPAL or GSA SEARCH:

Drupal search can simply be enabled by assigning the default search block to the header region.  

To use the GSA search:

1. Under Structure > Blocks, add a new block.
2. Paste in the following*:

<form role="search" method="get" action="http://www.novascotia.ca/snsmr/gsa2.asp"><input type="text" id="gsa" name="q" placeholder="Search novascotia.ca" /><button type="submit" id="searchButton" name="btnG">Search</button><input value="GOVNS" name="client" type="hidden"><input value="GOVNS" name="proxystylesheet" type="hidden"><input name="site" value="GOVNS" type="hidden"><input name="c" id="c" value="contact/" type="hidden"><input name="h" id="h" value="Government of Nova Scotia" type="hidden"><input name="i" id="i" value="img/banner1.jpg" type="hidden"><input name="j" id="j" value="" type="hidden"><input name="n" id="n" value="Contact Webmaster" type="hidden"><input value="1" id="proxyreload" name="proxyreload" type="hidden"><input value="xml_no_dtd" name="output" type="hidden"></form>

3. Assign your new block to the Header region & save.

* Ensure that the text format selected is Full HTML.  If you are using a WYSIWYG editor, 
  ensure that you paste the HTML into Source view.

-----------------------------------------------------------------------

Theme is based on the Government of Canada's Web Experience Toolkit (WET) and
distributed under MIT License.
