var regions={"HUB1":"Hub 1","HUB2":"Hub 2","HUB3":"Hub 3"},
w=jQuery('#vis').width(),h=550,
xmargin=100,
ymargin=40,
startYear=new Date(2016,2,1),
endYear=new Date(2017,3,1),
startAge=0,
endAge=550,
ylines=d3.scale.linear().domain([endAge,startAge]).range([0+ ymargin,h- ymargin]),
xlines=d3.time.scale().domain([new Date(2016,2,1),new Date(2017,3,1)]).range([0+ xmargin-5,w]),
years=d3.time.month.range(startYear,endYear);

var vis=d3.select("#vis").append("svg:svg").attr("width",w).attr("height",h).append("svg:g");
var line=d3.svg.line()
	.interpolate("basis")
	.x(function(d,i){
		return xlines(d.x);
	}).y(function(d){
		return ylines(d.y);
	});
var countries_regions={};
d3.text('country-regions.csv','text/csv',function(text){
	var regions=d3.csv.parseRows(text);
	for(i=1;i<regions.length;i++){
		countries_regions[regions[i][0]]=regions[i][1];
	}
});
var startEnd={},countryCodes={};
d3.text('life-expectancy-cleaned-all.csv','text/csv',function(text){
	var countries=d3.csv.parseRows(text);
	for(i=1;i<countries.length;i++){
		var values=countries[i].slice(2,countries[i.length-1]);
		// calculate cummulative values
		values[0] = parseFloat(values[0]);
		for (var j = 1; j < values.length; j++) {
			values[j] = parseFloat(values[j]) + parseFloat(values[j-1]);
		}
		var currData=[];
		countryCodes[countries[i][1]]=countries[i][0];
		var started=false;
		for(j=0;j<values.length;j++){
			if(values[j]!=''){
				currData.push({x:years[j],y:values[j]});
				if(!started){
					startEnd[countries[i][1]]={'startYear':years[j],'startVal':values[j]};started=true;
				} else if(j==values.length-1) {
					if (typeof(years[j]) == 'undefined') {
  					  startEnd[countries[i][1]]['endYear'] = Math.floor(xlines(years[j-1]));
					} else {
   					  startEnd[countries[i][1]]['endYear'] = Math.floor(xlines(years[j]));
					}
					startEnd[countries[i][1]]['endVal']=ylines(values[j]);
				}
			}
		}
		vis.append("svg:path").data([currData])
			.attr("country",countries[i][1])
			.attr("class",countries_regions[countries[i][1]])
			.attr("d",line)
			.on("mouseover",onmouseover).on("mouseout",onmouseout);
	}
});
vis.append("svg:line").attr("x1",xlines(new Date(2016,2,1)))
	.attr("y1",ylines(startAge))
	.attr("x2",xlines(new Date(2017,3,1)))
	.attr("y2",ylines(startAge))
	.attr("class","axis")
vis.append("svg:line")
	.attr("x1",xlines(startYear))
	.attr("y1",ylines(startAge))
	.attr("x2",xlines(startYear))
	.attr("y2",ylines(endAge))
	.attr("class","axis")
vis.append("svg:line")
	.attr("x1",xlines(startYear))
	.attr("y1",ylines(20))
	.attr("x2",xlines(endYear))
	.attr("y2",ylines(endAge))
	.attr("stroke-dasharray", "5,5")
	.attr("stroke-width", 2)
	.attr("class","target")

var tformat = d3.time.format("%Y-%m-%d");
vis.selectAll(".xLabel").data(xlines.ticks(8))
	.enter().append("svg:text")
	.attr("class","xLabel")
	.text(tformat)
	.attr("x",function(d){
		return xlines(d)
	})
	.attr("y",h-10).attr("text-anchor","middle")
vis.append("svg:text").attr("class", "siteLabel")
	.text("someSite").attr("x", 0).attr("y", 0);

var ytformat = function(x) { return "target at day " + (Math.floor(x/1.37)+31) }
vis.selectAll(".yLabel").data(ylines.ticks(5))
	.enter().append("svg:text")
	.attr("class","yLabel")
	.text(ytformat).attr("x",0)
	.attr("y",function(d){
		return ylines(d)
	}).attr("text-anchor","right").attr("dy",3)
vis.selectAll(".xTicks").data(xlines.ticks(12))
	.enter().append("svg:line")
	.attr("class","xTicks")
	.attr("x1",function(d){
		return xlines(d);
	})
	.attr("y1",ylines(startAge))
	.attr("x2",function(d){
		return xlines(d);
	}).attr("y2",ylines(startAge)+7)
vis.selectAll(".yTicks")
	.data(ylines.ticks(5))
	.enter()
	.append("svg:line")
	.attr("class","yTicks")
	.attr("y1",function(d){
		return ylines(d);
	})
	.attr("x1",xlines(new Date(2016,01,29)))
	.attr("y2",function(d){
		return ylines(d);
	}).attr("x2",xlines(new Date(2016,02,01)))

function onclick(d,i) {
	var currClass=d3.select(this).attr("class");
	if(d3.select(this).classed('selected')){
		d3.select(this).attr("class",currClass.substring(0,currClass.length-9));
	} else {
		d3.select(this).classed('selected',true);
	}
}
function onmouseover(d,i) {
	var currClass=d3.select(this).attr("class");
	d3.select(this).attr("class",currClass+" current");
	var siteCode=$(this).attr("country");
	var countryVals=startEnd[siteCode];
	
	d3.select('.siteLabel')
		.text(siteCode)
		.attr("y", countryVals.endVal)
		.attr("x", countryVals.endYear);
		//.attr('display', false);
	
	var percentChange=100*(countryVals['endVal']- countryVals['startVal'])/ countryVals['startVal'];
	var blurb='<h2>'+ countryCodes[siteCode]+'</h2>';
	blurb+="<p>On average: a life expectancy of "+ Math.round(countryVals['startVal'])+" years in "+ countryVals['startYear']+" and "+ Math.round(countryVals['endVal'])+" years in "+ countryVals['endYear']+", ";
	if(percentChange>=0){
		blurb+="an increase of "+ Math.round(percentChange)+" percent."
	} else {
		blurb+="a decrease of "+-1*Math.round(percentChange)+" percent."
	}
	blurb+="</p>";
	$("#default-blurb").hide();
	$("#blurb-content").html(blurb);
}
function onmouseout(d,i){
	var currClass=d3.select(this).attr("class");
	var prevClass=currClass.substring(0,currClass.length-8);
	d3.select(this).attr("class",prevClass);
	$("#default-blurb").show();
	$("#blurb-content").html('');
	//d3.select('.siteLabel').attr('display','none');
}
function showRegion(hubCode) {
	var countries=d3.selectAll("path."+hubCode);
	if(countries.classed('highlight')){
		countries.attr("class",hubCode);
	} else {
		countries.classed('highlight',true);
	}
}
