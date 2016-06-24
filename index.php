<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ABCD REPORT</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="images/touch/chrome-touch-icon-192x192.png">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="apple-touch-icon-precomposed.png">

    <!-- Tile icon for Win8 (144x144 + tile color) -->
    <meta name="msapplication-TileImage" content="images/touch/ms-touch-icon-144x144-precomposed.png">
    <meta name="msapplication-TileColor" content="#3372DF">

    <link href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="css/dialog-polyfill.css">
    <link rel="stylesheet" href="css/material.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <!-- <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.print.css" media="print">  -->

    <style>
    #view-source {
      position: fixed;
      display: block;
      right: 0;
      bottom: 0;
      margin-right: 40px;
      margin-bottom: 40px;
      z-index: 900;
    }
    </style>

<?php
   session_start();
   include("code/php/AC.php");
   $user_name = check_logged(); /// function checks if visitor is logged.
   echo('<script type="text/javascript"> user_name = "'.$user_name.'"; </script>'."\n");

   $admin = false;
   if (check_role( "admin" )) {
     $admin = true;
   }
   
?>
    
  </head>
  <body>
    <div class="demo-layout mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="demo-header mdl-layout__header mdl-color--white mdl-color--grey-100 mdl-color-text--grey-600">
        <div class="mdl-layout__header-row">
          <span class="mdl-layout-title">&nbsp;&nbsp;ABCD REPORT</span>
          <div class="mdl-layout-spacer"></div>

          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="account">
            <i class="material-icons">account_box</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="account">
            <li class="mdl-menu__item" id="change-password">change password</li>
            <li class="mdl-menu__item" onclick="logout();">logout</li>
          </ul>
	  <span class="user_name" title="Current user">unknown</span>

<?php if ($admin) : ?>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="admin" title="Adminstrative tools">
            <i class="material-icons">edit</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="admin">
            <li class="mdl-menu__item"><a href="/applications/User/admin.php">User administration</a></li>
          </ul>	  
<?php endif; ?>

<!--	  <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class="mdl-button mdl-js-button mdl-button--icon" for="search">
              <i class="material-icons">search</i>
            </label>
            <div class="mdl-textfield__expandable-holder">
              <input class="mdl-textfield__input" type="text" id="search" />
              <label class="mdl-textfield__label" for="search">Enter your query...</label>
            </div>
          </div>
          <button class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--icon" id="hdrbtn">
            <i class="material-icons">more_vert</i>
          </button>
          <ul class="mdl-menu mdl-js-menu mdl-js-ripple-effect mdl-menu--bottom-right" for="hdrbtn">
            <li class="mdl-menu__item">About</li>
            <li class="mdl-menu__item">Contact</li>
            <li class="mdl-menu__item">Legal information</li>
          </ul> -->
        </div>
      </header>
      <main class="mdl-layout__content mdl-color--grey-100">

	<div class="mdl-grid">
	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-tlfb assessment-block"><a href="/applications/timeline-followback/index.php">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">Timeline Followback</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">Capture substance use profiles</p>
            </div></a>
	  </div>
	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-lmt assessment-block"><a href="/applications/little-man-task/index.php">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">Little Man Task</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">Mental rotation</p>
            </div></a>
	  </div>
	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-enroll assessment-block"><a href="https://abcdcontact.me:8888" title="requires access to VPN @MIL">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">PII Database</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">VPN access required</p>
            </div></a>
	  </div>

	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-stroop assessment-block"><a href="/applications/stroop/index.php">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">Stroop Test</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">Color/Word test</p>
            </div></a>
	  </div>

	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-delay-discounting assessment-block"><a href="/applications/delay-discount/index.php">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">Delay-Discounting</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">A buck now?</p>
            </div></a>
	  </div>

	  <div class="mdl-cell--3--col mdl-cell mdl-shadown--2dp assessment-block-aux-file-upload assessment-block"><a href="/applications/aux-file-upload/index.php">
	    <div class="assessment-text">
              <div class="mdl-typography--display-2 mdl-typography--font-thin">File Upload</div>
	      <p class="mdl-typography--headline mdl-typography--font-thin">fMRI Imaging</p>
            </div></a>
	  </div>
	  
        </div>


	  <!--         <div class="mdl-grid">
          <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid" style="position: relative; height: 450px;">
              <div id="map-canvas" style="position: absolute; left: 0px; top: 0px; overflow: hidden; width: 100%; height: 100%; z-index: 0"></div>
          </div>        
        </div>        
        
        <div class="mdl-grid" >
          <div class="demo-graphs mdl-shadow--2dp mdl-color--white mdl-cell mdl-cell--10-col">
              <h4>Schedule</h4>
              <div id="calendar"></div>
          </div>
          <div class="demo-cards mdl-cell mdl-cell--2-col mdl-cell--8-col-tablet mdl-grid mdl-grid--no-spacing">
            <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__title mdl-card--expand mdl-color--teal-300">
                <h2 class="mdl-card__title-text">Updates</h2>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                All sites are supposed will be scanning early next year.
              </div>
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect">Read More</a>
              </div>
            </div>
            <div class="demo-separator mdl-cell--1-col"></div>
            <div class="demo-options mdl-card mdl-color--deep-purple-500 mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--3-col-tablet mdl-cell--12-col-desktop">
              <div class="mdl-card__actions mdl-card--border">
                <a href="#" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-color-text--blue-grey-50">Locations</a>
                <div class="mdl-layout-spacer"></div>
                <i class="material-icons">location_on</i>
              </div>
              <div class="mdl-card__supporting-text mdl-color-text--blue-grey-50">
                <ul>
                  <li>
                    <label for="chkbox1" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox1" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UCSD</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox2" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox2" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">Oklahoma</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox3" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox3" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">FIU</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox4" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox4" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">SRI</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox5" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox5" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">Hawaii</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox6" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox6" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">USC</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox7" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox7" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UCLA</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox8" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox8" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UMich</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox9" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox9" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UFL</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox10" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox10" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">Cornell</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox11" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox11" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">MtSinai</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox12" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox12" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">Utah</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox13" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox13" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UMinn</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox14" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox14" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">WUSTL</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox15" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox15" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">VCU</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox16" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox16" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">Boulder</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox17" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox17" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UVM</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox18" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox18" class="mdl-checkbox__input" checked/>
                      <span class="mdl-checkbox__label">OHSU</span>
                    </label>
                  </li>
                  <li>
                    <label for="chkbox19" class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect">
                      <input type="checkbox" id="chkbox19" class="mdl-checkbox__input"  checked/>
                      <span class="mdl-checkbox__label">UPMC</span>
                    </label>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        
        <div class="demo-charts mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
              <use xlink:href="#piechart" mask="url(#piemask)" />
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">10<tspan font-size="0.2" dy="-0.07">%</tspan>
              <tspan font-size="0.1" dy="0.2" dx="-0.4">scans</tspan>
              </text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
              <use xlink:href="#piechart" mask="url(#piemask)" />
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan>
              <tspan font-size="0.1" dy="0.2" dx="-0.4">space</tspan>
              </text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
              <use xlink:href="#piechart" mask="url(#piemask)" />
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan>
              <tspan font-size="0.1" dy="0.2" dx="-0.4">target</tspan>              
              </text>
            </svg>
            <svg fill="currentColor" width="200px" height="200px" viewBox="0 0 1 1" class="demo-chart mdl-cell mdl-cell--4-col mdl-cell--3-col-desktop">
              <use xlink:href="#piechart" mask="url(#piemask)" />
              <text x="0.5" y="0.5" font-family="Roboto" font-size="0.3" fill="#888" text-anchor="middle" dy="0.1">82<tspan dy="-0.07" font-size="0.2">%</tspan>
              <tspan font-size="0.1" dy="0.2" dx="-0.58">completeness</tspan>              
              </text>
            </svg>
        </div>

        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
          <div class="mdl-card__actions mdl-card--border">

             <H4>Demographics Report</H4>
             <center>
                 <div id="demographics"></div>
             </center>
          </div>
        </div>        
        
        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
          <div class="mdl-card__actions mdl-card--border">

             <H4>Enrollment Report</H4>
             <center>
                 <div id="enrollment"></div>
             </center>
          </div>
        </div>        

        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
          <div class="mdl-card__actions mdl-card--border">

             <H4>SES by Site</H4>
             <center>
                 <div id="ses"></div>
             </center>
          </div>
        </div>        

        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
          <div class="mdl-card__actions mdl-card--border">

            <div id="filters">
              <a id="HUB1" class="HUB1">Hub 1 (Site A, Site B, Site C)</a>
              <a id="HUB2" class="">Site D</a>
              <a id="HUB3" class="">Site E</a>
              <a id="HUB4" class="">Hub 2 (Site F, Site G, Site H)</a>
              <a id="HUB5" class="">Hub 3 (Site I, Site J)</a>
            </div>
            <div id="vis"></div>
          </div>
        </div>        -->
      </main>
      
    </div>

    <dialog class="mdl-dialog" id="change-password-dialog">
      <h4 class="mdl-dialog__title">Change Password</h4>
      <div class="mdl-dialog__content">
	<p>
	  <form>
	    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
  	      <input class="mdl-textfield__input" id="password-field1" type="password" autofocus="">
	      <label class="mdl-textfield__label" for="password-field1">Enter new password</label>
	    </div>
	    <br>
	    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
  	      <input class="mdl-textfield__input" id="password-field2" type="password">
	      <label class="mdl-textfield__label" for="password-field1">Enter new password again</label>
	    </div>
	  </form>
	</p>
      </div>
      <div class="mdl-dialog__actions">
	<button class="button btn mdl-button close" type="button">Cancel</button>
	<button class="button btn mdl-button mdl-button--raised mdl-js-ripple-effect close" onclick="changePassword();" type="button">Submit</button>
      </div>
    </dialog>
    
      <div id="tooltip-container">
         <div class="tooltip_kv">
            <span class="tooltip_key"></span>
            <span class="tooltip_value"></span>
         </div>
      </div>


      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" style="position: fixed; left: -1000px; height: -1000px;">
        <defs>
          <mask id="piemask" maskContentUnits="objectBoundingBox">
            <circle cx=0.5 cy=0.5 r=0.49 fill="white" />
            <circle cx=0.5 cy=0.5 r=0.40 fill="black" />
          </mask>
          <g id="piechart">
            <circle cx=0.5 cy=0.5 r=0.5 />
            <path d="M 0.5 0.5 0.5 0 A 0.5 0.5 0 0 1 0.95 0.28 z" stroke="none" fill="rgba(255, 255, 255, 0.75)" />
          </g>
        </defs>
      </svg>
    <!--  <a href="https://github.com/google/material-design-lite/blob/master/templates/dashboard/" target="_blank" id="view-source" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-color--accent mdl-color-text--accent-contrast">View Source</a> -->
    <script src="js/material.min.js"></script>
    <script src="js/dialog-polyfill.js"></script>
    <script src="//code.jquery.com/jquery-2.1.4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <!--   <script src="http://media.flowingdata.com/js/d3.time.js?1.29.1" type="text/javascript"></script> -->
    <!--  <script src="http://media.flowingdata.com/js/d3.csv.js?1.29.1" type="text/javascript"></script> -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/topojson/1.1.0/topojson.min.js"></script>    
    <script src="//maps.googleapis.com/maps/api/js?sensor=false&v=3&key=AIzaSyDyQ724f8tTmdRYiVncVyMiJCYDp-Tc6YU"></script>
    <script src="js/map.js"></script>
    <script src="js/demographics.js"></script>
    <script src="js/enrollment.js"></script>
    <script src="js/sesbysite.js"></script>
    <script src="js/lines.js"></script>
    <script src='//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js'></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.4.0/fullcalendar.min.js"></script>
    <script>

      // logout the current user
function logout() {
    jQuery.get('/code/php/logout.php', function(data) {
	if (data == "success") {
	    // user is logged out, reload this page
	} else {
	    alert('something went terribly wrong during logout: ' + data);
	}
	window.location.href = "applications/User/login.php";
    });
}
      
      var marker = [];
      var infowindows = [];

      function changePassword() {
	  var password = jQuery('#password-field1').val();
	  var password2 = jQuery('#password-field2').val();
	  if (password == "") {
	      alert("Error: Password cannot be empty.");
	      return; // no empty passwords
	  }
	  hash = hex_md5(password);
	  hash2 = hex_md5(password2);
	  if (hash !== hash2) {
	      alert("Error: The two passwords are not the same, please try again.");
	      return; // do nothing
	  }
	  jQuery.getJSON('/code/php/getUser.php?action=changePassword&value=' + user_name + '&value2=' + hash, function(data) {
	      // did this work?
	  });
      }
      
      jQuery(document).ready(function() {          

         jQuery('#change-password').click(function() {
            var dialog = document.getElementById('change-password-dialog');
            if (! dialog.showModal) {
                dialogPolyfill.registerDialog(dialog);
            }
            dialog.showModal();
            dialog.querySelector('.close').addEventListener('click', function() {
                 dialog.close();
            });
         });
      
         jQuery('.user_name').text(user_name);

      // create map
          google.maps.event.addDomListener(window, 'load', initialize);
          jQuery('#calendar').fullCalendar({			
             header: {
				       left: 'prev,next today',
				       center: 'title',
			       	 right: 'month,basicWeek,basicDay,agendaWeek'
			       },
             defaultDate: new Date(2016,1,1),
			       firstDay: new Date(2016,3,1),
             timezone: 'America/Los_Angeles',
			       editable: true,
			       eventLimit: true, // allow "more" link when too many events})
             googleCalendarApiKey: 'AIzaSyCUn6gzEzqlhZ_7LSyqdVDOWDhobrkdS5Q',
             events: [
			         {
			     	      title: 'Data Camp',
				          start: '2016-03-01'
		 	         },
			         {
			     	      title: 'Scan A0234',
                  id: 2,
				          start: '2016-03-02T9:00:00',
				          end: '2016-03-02T10:00:00'
		 	         },
			         {
			     	      title: 'Scan A0237',
                  id: 1,
				          start: '2016-03-02T9:00:00',
				          end: '2016-03-02T10:00:00'
		 	         },
			         {
			     	      title: 'Assess. A0234',
                  id: 3,
				          start: '2016-03-02T14:00:00',
                  end: '2016-03-02T16:00:00'
		 	         },
			         {
			     	      title: 'Assess. A0734',
                  id: 4,
				          start: '2016-03-03T14:00:00',
                  end: '2016-03-03T16:00:00'
		 	         }                
             ],
             eventSources: [
                {
                 googleCalendarId: '3d130hksr4l7l1pn8jhpdngsts@group.calendar.google.com'
                },
                {
                 googleCalendarId: 'efgh5678@group.calendar.google.com',
                 className: 'nice-event'
                }
             ]            
          });
          
          // create graphs
          
          var freqData=[
             {State:'SiteA',ses:{low:478, mid:131, high:24}}
            ,{State:'SiteB',ses:{low:110, mid:41, high:67}}
            ,{State:'SiteC',ses:{low:93, mid:214, high:41}}
            ,{State:'SiteD',ses:{low:83, mid:115, high:186}}
            ,{State:'SiteE',ses:{low:448, mid:334, high:94}}
            ,{State:'SiteF',ses:{low:161, mid:16, high:106}}
            ,{State:'SiteG',ses:{low:181, mid:27, high:120}}
            ,{State:'SiteH',ses:{low:449, mid:385, high:94}}
          ];
          dashboard('#ses',freqData);
          
          // create lines
          jQuery('#filters a').click(function() {
            var countryId = $(this).attr("id");
            $(this).toggleClass(countryId);
            showRegion(countryId);
          });
          setTimeout(function() { showRegion("HUB1"); }, 100);
      });

    </script>
    
  </body>
</html>
