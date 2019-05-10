1.  Figure out how to have the thing respecting limit and offset.       DONE

2.  Add an edit button.                                                 DONE

3.  Get results per page working.

4.  Get pagination working.

5.  Get search records working.

----------------------------------

BONUS TO DO:

*  Build a js function for converting unix timestamp.

*  Build a js function for limiting characters.

*  Consider building a function for currency.

*  Do a 'not found' info message if no comments.





                                                <div class="w3-dropdown-click">
                                          <button id="per-page"><?= $limit_pref ?></button>
                                          <div id="per-page-options" class="w3-dropdown-content w3-bar-block w3-border" style="right:0">
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(10)">10</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(20)">20</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(50)">50</a>
                                            <a href="#" class="w3-bar-item w3-button" onClick="sayPerPageLimit(100)">100</a>
                                          </div>
                                        </div>