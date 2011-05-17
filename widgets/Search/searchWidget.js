var site = 0;

function byteSizeOrdering() {
 	jQuery.tablesorter.addParser(
    {
        id: 'filesize',
        is: function (s)
        {
            return s.match(new RegExp(/[0-9]+(\.[0-9]+)?\ (KB|B|GB|MB|TB)/i));
        },
        format: function (s)
        {
            var suf = s.match(new RegExp(/(KB|B|GB|MB|TB)$/i))[1];
            var num = parseFloat(s.match(new RegExp(/^[0-9]+(\.[0-9]+)?/))[0]);
            switch (suf)
            {
            case 'B':
                return num;
            case 'KB':
                return num * 1024;
            case 'MB':
                return num * 1024 * 1024;
            case 'GB':
                return num * 1024 * 1024 * 1024;
            case 'TB':
                return num * 1024 * 1024 * 1024 * 1024;
            }
        },
        type: 'numeric'
    });

}


function updateRows()
{
    $("table#search-Table tr:odd").addClass("odd");
    $("table#search-Table tr:even").removeClass("odd");
}

function results()
{
    var item = $("#searchterm").val();

    if (item === "")
    {
        alert("Search field is empty");
        return false;
    }
    else
    {
        getResults(item);
    }
}

function getResults(item)
{
	$.prettyLoader();
    $("div#resultstable").show();
    $("#extra_info").html("");
	var type = $("#type").val();
	$.ajax({
	  type: 'GET',
	  url: "widgets/wSearch.php?site=" + site + "&q=" + item + "&type=" + type,
	  beforeSend:function(){
	    // this is where we append a loading image
	    //$('#ajax-panel').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
		$.prettyLoader.show();
	  },
	  success:function(data){
	    // successful request; do something with the data
        $("#resultstable").html(data);
	    //var is = ic.getElementsByTagName('img');
	    //for (var i=0; i< is.length; i++) {
	    //        ajax_cf.addItem(is[i], 'last');
	    //}
        
        
      

        $("table#search-Table tr:odd").addClass("odd");
        if(site != 3)
        {
	        byteSizeOrdering();
	        $("#search-Table").tablesorter(
	        {
	            headers: 
	            {
	                2: 
	                {
	                    sorter: 'filesize'
	                }
	            }
	        });
        }
        else
        {
	        $("#search-Table").tablesorter();
        }
  		$("a[rel^='prettyPhoto']").prettyPhoto(
        {
            social_tools: false
        });
  		$.prettyLoader.hide();        
      },
	  error:function(){
	    // failed request; give feedback to user
        alert("Sorry, but I couldn't create an XMLHttpRequest");
	  }
	});

}

function clearResults()
{
    $("#resultstable").html("");
    $("#extra_info").html("");
    $("#cast").html("");
    $("#resultstable").show();
}


function catDropDown(str)
{
    if(str == 0)
    {
    	site=0;
    	$("#type").hide();
    }
    else if (str == 1)
    {
        $("#type").html("<option value=\"\">Everything</option><option  class=\"grouping\" value=\"1000\">Console</option><option  value=\"1010\">&nbsp;&nbsp;NDS</option><option  value=\"1080\">&nbsp;&nbsp;PS3</option><option  value=\"1020\">&nbsp;&nbsp;PSP</option><option  value=\"1030\">&nbsp;&nbsp;Wii</option><option  value=\"1060\">&nbsp;&nbsp;WiiWare/VC</option><option  value=\"1070\">&nbsp;&nbsp;XBOX 360 DLC</option><option  value=\"1040\">&nbsp;&nbsp;Xbox</option><option  value=\"1050\">&nbsp;&nbsp;Xbox 360</option><option  class=\"grouping\" value=\"2000\">Movies</option><option  value=\"2010\">&nbsp;&nbsp;Foreign</option><option  value=\"2040\">&nbsp;&nbsp;HD</option><option  value=\"2020\">&nbsp;&nbsp;Other</option><option  value=\"2030\">&nbsp;&nbsp;SD</option><option  class=\"grouping\" value=\"3000\">Audio</option><option  value=\"3030\">&nbsp;&nbsp;Audiobook</option><option  value=\"3040\">&nbsp;&nbsp;Lossless</option><option  value=\"3010\">&nbsp;&nbsp;MP3</option><option  value=\"3020\">&nbsp;&nbsp;Video</option><option  class=\"grouping\" value=\"4000\">PC</option><option  value=\"4010\">&nbsp;&nbsp;0day</option><option  value=\"4050\">&nbsp;&nbsp;Games</option><option  value=\"4020\">&nbsp;&nbsp;ISO</option><option  value=\"4030\">&nbsp;&nbsp;Mac</option><option  value=\"4040\">&nbsp;&nbsp;Phone</option><option  class=\"grouping\" value=\"5000\">TV</option><option  value=\"5020\">&nbsp;&nbsp;Foreign</option><option  value=\"5040\">&nbsp;&nbsp;HD</option><option  value=\"5050\">&nbsp;&nbsp;Other</option><option  value=\"5030\">&nbsp;&nbsp;SD</option><option  value=\"5060\">&nbsp;&nbsp;Sport</option><option  class=\"grouping\" value=\"6000\">XXX</option><option  value=\"6010\">&nbsp;&nbsp;DVD</option><option  value=\"6020\">&nbsp;&nbsp;WMV</option><option  value=\"6030\">&nbsp;&nbsp;XviD</option><option  value=\"6040\">&nbsp;&nbsp;x264</option><option  class=\"grouping\" value=\"7000\">Other</option><option  value=\"7030\">&nbsp;&nbsp;Comics</option><option  value=\"7020\">&nbsp;&nbsp;Ebook</option><option  value=\"7010\">&nbsp;&nbsp;Misc</option>");
        site = 1;
        $("#type").show();
    }
    else if (str == 2)
    {
        $("#type").html("<option value=\"0\">Everything</option><optgroup label=\"Movies\">Movies<option value=\"1\">Movies: DVD</option><option value=\"2\">Movies: Divx/Xvid</option><option value=\"54\">Movies: BRRip</option><option value=\"42\">Movies: HD (x264)</option><option value=\"50\">Movies: HD (Image)</option><option value=\"48\">Movies: WMV-HD</option><option value=\"3\">Movies: SVCD/VCD</option><option value=\"4\">Movies: Other</option>  </optgroup><optgroup label=\"TV\"><option value=\"5\">TV: DVD</option><option value=\"6\">TV: Divx/Xvid</option><option value=\"41\">TV: HD</option><option value=\"7\">TV: Sport/Ent</option><option value=\"8\">TV: Other</option></optgroup><optgroup label=\"Documentaries\"><option value=\"9\">Documentaries: STD</option><option value=\"53\">Documentaries: HD</option></optgroup><optgroup label=\"Games\"><option value=\"10\">Games: PC</option><option value=\"11\">Games: PS2</option><option value=\"43\">Games: PS3</option><option value=\"12\">Games: PSP</option><option value=\"13\">Games: Xbox</option><option value=\"14\">Games: Xbox360</option><option value=\"56\">Games: Xbox360 (Other)</option><option value=\"15\">Games: PS1</option><option value=\"16\">Games: Dreamcast</option><option value=\"44\">Games: Wii</option><option value=\"51\">Games: Wii VC</option><option value=\"45\">Games: DS</option><option value=\"46\">Games: GameCube</option><option value=\"17\">Games: Other</option></optgroup><optgroup label=\"Apps\"><option value=\"18\">Apps: PC</option><option value=\"19\">Apps: Mac</option><option value=\"52\">Apps: Portable</option><option value=\"20\">Apps: Linux</option><option value=\"55\">Apps: Phone</option><option value=\"21\">Apps: Other</option></optgroup><optgroup label=\"Music\"><option value=\"22\">Music: MP3 Albums</option><option value=\"47\">Music: MP3 Singles</option><option value=\"23\">Music: Lossless</option><option value=\"24\">Music: DVD</option><option value=\"25\">Music: Video</option><option value=\"27\">Music: Other</option><optgroup label=\"Anime\"><option value=\"28\" style=\"font-weight: bold;\">Anime: ALL</option></optgroup><optgroup label=\"Other\"><option value=\"49\">Other: Audio Books</option><option value=\"33\">Other: Emulation</option><option value=\"34\">Other: PPC/PDA</option><option value=\"26\">Other: Radio</option><option value=\"36\">Other: E-Books</option><option value=\"37\">Other: Images</option><option value=\"38\">Other: Mobile Phone</option><option value=\"39\">Other: Extra Pars/Fills</option><option value=\"40\">Other: Other</option></optgroup>");
        site = 2;
        $("#type").show();
    }
    else if (str == 3)
    {
        site = 3;
        $("#type").hide();
    }
}

function resetWidget()
{
    site = 0;
    $("#type").hide();
    $("#searchterm").val("");
    document.getElementById('provider')[0].selected = true;
    clearResults();
}

function getExtra(id)
{
	
	$.ajax({
	  type: 'GET',
	  url:  "widgets/wSearch.php?id=" + id,
	  beforeSend:function(){
	    // this is where we append a loading image
	    //$('#ajax-panel').html('<div class="loading"><img src="/images/loading.gif" alt="Loading..." /></div>');
		$.prettyLoader.show();
	  },
	  success:function(data){
	    // successful request; do something with the data
        $("#resultstable").hide();
        $("#extra_info").show();
        $("#extra_info").html(data);
        $("a[rel^='prettyPhoto']").prettyPhoto(
        {
            social_tools: false
        });
       	$.prettyLoader.hide();
	  },
	  error:function(){
	    // failed request; give feedback to user
        alert("Sorry, but I couldn't create an XMLHttpRequest");
	  }
	});
}

function closeExtra()
{
    $("#extra_info").hide();
    $("#resultstable").show();
    $("#videoTrailer").html("");
}

function toggleCast()
{
    if (document.getElementById("cast").style.display == "none")
    {
        document.getElementById("cast").style.display = "inline-block";
    }
    else
    {
        $("#cast").hide();
    }

}