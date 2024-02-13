!function(){"use strict";function t(){this.body=document.querySelector("body"),this.charts=[]}t.prototype.respChart=function(t,a,r,e){var o,n=Chart.controllers.bar.prototype.draw,s=(Chart.controllers.bar.draw=function(){n.apply(this,arguments);var t=this.chart.ctx,a=t.fill;t.fill=function(){t.save(),t.shadowColor="rgba(0,0,0,0.01)",t.shadowBlur=5,t.shadowOffsetX=4,t.shadowOffsetY=5,a.apply(this,arguments),t.restore()}},Chart.defaults.font.color="rgba(93,106,120,0.2)",Chart.defaults.scale.grid.color="rgba(93,106,120,0.2)",t.getContext("2d")),i=t.parentNode;switch(t.setAttribute("width",i.offsetWidth),a){case"Line":o=new Chart(s,{type:"line",data:r,options:e});break;case"Doughnut":o=new Chart(s,{type:"doughnut",data:r,options:e});break;case"Pie":o=new Chart(s,{type:"pie",data:r,options:e});break;case"Bar":o=new Chart(s,{type:"bar",data:r,options:e});break;case"Radar":o=new Chart(s,{type:"radar",data:r,options:e});break;case"PolarArea":o=new Chart(s,{data:r,type:"polarArea",options:e})}return o},t.prototype.initCharts=function(){var t,a=[],r=document.getElementById("high-performing-product");return r&&((t=r.getContext("2d").createLinearGradient(0,500,0,150)).addColorStop(0,"#409c6b"),t.addColorStop(1,"#3e60d5"),a.push(this.respChart(r,"Bar",{labels:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],datasets:[{label:"Orders",backgroundColor:t,borderColor:t,hoverBackgroundColor:t,hoverBorderColor:t,data:[65,59,80,81,56,89,40,32,65,59,80,81]},{label:"Revenue",backgroundColor:"rgba(93,106,120,0.2)",borderColor:"rgba(93,106,120,0.2)",hoverBackgroundColor:"rgba(93,106,120,0.2)",hoverBorderColor:"rgba(93,106,120,0.2)",data:[89,40,32,65,59,80,81,56,89,40,65,59]}]},{maintainAspectRatio:!1,datasets:{bar:{barPercentage:.7,categoryPercentage:.5}},plugins:{legend:{display:!1}},scales:{y:{grid:{display:!1,color:"rgba(0,0,0,0.05)"},stacked:!1,ticks:{stepSize:20}},x:{stacked:!1,grid:{color:"rgba(0,0,0,0.01)"}}}}))),a},t.prototype.init=function(){var a=this;Chart.defaults.font.family='-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',a.charts=this.initCharts(),window.addEventListener("resize",function(t){a.charts.forEach(function(t){try{t.destroy()}catch(t){}}),a.charts=a.initCharts()})},(new t).init()}();