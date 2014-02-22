// JavaScript Document
function dropNav(obj){
	$(obj).each(function(){
						 var theSpan=$(this);
						 var theUl=theSpan.find("ul");
						 var theHeight=theUl.height();
						 theUl.css({height:0,opacity:0});
						 theSpan.hover(function(){
												$(this).addClass("nav-list-1");
												theUl.stop().show().animate({height:theHeight,opacity:1},400);

												},function(){
													$(this).removeClass("nav-list-1");
													theUl.stop().show().animate({height:0,opacity:0},400,
																				function(){
																					$(this).css({display:"none"});
																					})});                                                 
						 });
	}
	$(document).ready(function(){
	
	dropNav(".nav-list");

});


var def="0";
function changetop(object){
	var topnav=document.getElementById("top-nav"+object);
	topnav.className="cur";
	if(def!=0){
		var mdef=document.getElementById("top-nav"+def);
		mdef.className="topnav";
	}
	var ss=document.getElementById("top-sub"+object);
	ss.style.display="block";
	
	//��ʼ�Ӳ˵�������Ч��
	if(def!=0){
		var sdef=document.getElementById("top-sub"+def);
		sdef.style.display="none";
	}
	}
function changetop2(object){

	//���˵�
	var mm=document.getElementById("top-nav"+object);
	mm.className="topnav";
	
	//��ʼ���˵���ԭЧ��
	if(def!=0){
		var mdef=document.getElementById("top-nav"+def);
		mdef.className="cur";
	}
	
	//�Ӳ˵�
	var ss=document.getElementById("top-sub"+object);
	ss.style.display="none";
	
	//��ʼ�Ӳ˵���ԭЧ��
	if(def!=0){
		var sdef=document.getElementById("top-sub"+def);
		sdef.style.display="block";
	}
	
}
