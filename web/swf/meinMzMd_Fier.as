/*
//////////////////////////////////////////////////////////////////////////////
///
This code is like licenced WhateverCreativeUncommon...
Feel free to use it, abuse it, spread it, suck it, etc...
No need to quote or credits, just help yasself and smile...
I'll b glad that this few oldskewl AS1 linez could help anyone so, enjoy !!!

Glafouk /=/ March/May/June 2K8
///
//////////////////////////////////////////////////////////////////////////////
*/

System.useCodepage = true;

import flash.external.ExternalInterface;

var sMonUrlDeBaseDeStyle:String; 
var sMonUrlDePlaylist:String;
var sMaCouleurDeClignottement :String;
var sMaCouleurDeTrais :String;
var aMesBoutonsDeControl:Array = [buPrev,buNext,buPlay,buStop,buStyle];
var aMesStyles:Array = ["random","acid","bass","chip"];
var aMesTracks:Array = [];
var nIndexTrack:Number;
var sndMonTrack:Sound;
var nPosition:Number;
var nTemps:Number = 0;
var nDureeClignottement:Number = 8;
var bClignotte:Boolean = true;
var mcBoutonPlayStopEnCours:MovieClip;
var mcBoutonDeStyleEnCours:MovieClip;
var aMaPalette:Array = ["FC5654","54FE54","FCFE54","5456FC","FC56FC","54FEFC"];
var bXmlCharge:Boolean;
/////////////////////////////////////////////////////////////
function recupereUnXml(sQuelXml:String)
{
	bXmlCharge = false;
	mcTitle.field.text = "LOADING-DECRUNCHING";
	mcTitle.field.autoSize = "Left";
	mcTitle.bAvance = true;
	mcAntiClick._visible = true;
	var monXml = new XML();   
	monXml.ignoreWhite = true;
	monXml.oNiveau = this;
	monXml.onLoad = function(wellDone)
	{
		if (wellDone) 
		{
			aMesTracks = [];
			if(this.childNodes[0].firstChild!=undefined) 
			{
				for (cpt0=0; cpt0<monXml.childNodes.length; cpt0++) 
				{   
					if (this.childNodes[cpt0].nodeName == "playlist") 
					{
						var premierNoeud = this.childNodes[cpt0];
					}
				}
				for (cpt1=0; cpt1<premierNoeud.childNodes.length; cpt1++) 
				{
					if (premierNoeud.childNodes[cpt1].nodeName == "trackList") 
					{
						trace(premierNoeud.childNodes[cpt1].nodeName)
						var secondNoeud = premierNoeud.childNodes[cpt1];
						for (cpt2=0; cpt2<secondNoeud.childNodes.length; cpt2++)
						{
							if(secondNoeud.childNodes[cpt2].nodeName=="track")
							{
								var sUrl,sTitre,sAuteur:String;
								troisiemeNoeud = secondNoeud.childNodes[cpt2];
								for (cpt3=0; cpt3<troisiemeNoeud.childNodes.length; cpt3++)
								{
									if(troisiemeNoeud.childNodes[cpt3].nodeName=="location")
									{
										sUrl = troisiemeNoeud.childNodes[cpt3].firstChild.nodeValue;
									}
									else if(troisiemeNoeud.childNodes[cpt3].nodeName=="title")
									{
										sTitre = troisiemeNoeud.childNodes[cpt3].firstChild.nodeValue;
									}
									else if(troisiemeNoeud.childNodes[cpt3].nodeName=="creator")
									{
										sAuteur = troisiemeNoeud.childNodes[cpt3].firstChild.nodeValue;
									}
								}
								aMesTracks.push({url:sUrl , titre:sTitre, artiste:sAuteur});
							}
						}
					}
				}
			}
			if (sMonStyleVoulu == "random") {
				aMesTracks.sort(shuffle);
			}
			mcAntiClick._visible = false;
			nIndexTrack = random(aMesTracks.length);
			buNext.mcSensitive.onRelease();
			bXmlCharge = true;
		}
	}
	monXml.load(sQuelXml);
}

function colorize(mc:MovieClip,sCouleur:String)
{
	var maCouleur:Color = new Color(mc);
	maCouleur.setRGB(Number("0x"+sCouleur));
}

function calculeLeCycleDeClignottement()
{
	nTemps++;
	if(nTemps>nDureeClignottement)
	{
		if(bClignotte)
		{
			bClignotte = false;
		}
		else
		{
			bClignotte = true;
		}
		nTemps = 0;
	}
}

function jeClignotte(mc:MovieClip,sCouleurA:String,sCouleurB:String,bActif:Boolean)
{
	if(bActif)
	{
		mc.onEnterFrame = function()
		{
			if(bClignotte)
			{
				colorize(mc,sCouleurA);
			}
			else
			{
				colorize(mc,sCouleurB);
			}
		}
	}
	else
	{
		delete mc.onEnterFrame;
		colorize(mc,sCouleurA);
	}
}

function gestionBoutonPlayStopEnCours(mc:MovieClip)
{
		mcBoutonPlayStopEnCours.mcSensitive.enabled = true;
		jeClignotte(mcBoutonPlayStopEnCours.mcSymbolColor,sMaCouleurDeTrais);
		jeClignotte(mcBoutonPlayStopEnCours.mcFilledColor,sMaCouleurDeTrais);
		mcBoutonPlayStopEnCours = mc;
		mcBoutonPlayStopEnCours.mcSensitive.enabled = false;
		jeClignotte(mcBoutonPlayStopEnCours.mcSymbolColor,"000000",sMaCouleurDeTrais,true);
		jeClignotte(mcBoutonPlayStopEnCours.mcFilledColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);	
}

function initLeCycleDeCouleurDesBarres(mc:MovieClip,nDureeDuCycle:Number)
{
	mc.nTemps = 0;
	mc.nIndex = random(aMaPalette.length);
	mc.nDureeDuCycle = nDureeDuCycle;
}

function calculeLeCycleDeCouleurDesBarres(mc:MovieClip)
{
	mc.nTemps++;
	if(mc.nTemps>mc.nDureeDuCycle)
	{
		mc.nIndex++;
		if(mc.nIndex>aMaPalette.length-1) mc.nIndex = 0;
		colorize(mc,aMaPalette[mc.nIndex]);
		mc.nTemps = 0;
	}
	
}

function afficheLeTitre()
{
	mcTitle.field.text = aMesTracks[nIndexTrack].titre.toUpperCase() + " - " + aMesTracks[nIndexTrack].artiste.toUpperCase();
	mcTitle.field.autoSize = "Left";
	mcTitle.bAvance = true;
}

function faitBougerLeTitre()
{
	if(mcTitle._width>mcReferenceBar._x+mcReferenceBar._width-60&&mcTitle._width<mcReferenceBar._width)
	{	
		mcTitle._x = mcReferenceBar._x + (mcReferenceBar._width-mcTitle._width)/2;
	}
	else
	{
		if(mcTitle.bAvance)
		{
			mcTitle._x += 3;
		}
		else
		{
			mcTitle._x -= 3;
		}
	}
	if(mcTitle._width<mcReferenceBar._width)
	{
		if(mcTitle._x>mcReferenceBar._x+mcReferenceBar._width-mcTitle._width-5) mcTitle.bAvance = false;
		if(mcTitle._x<mcReferenceBar._x+5) mcTitle.bAvance = true;
	}
	else
	{
		if(mcTitle._x>mcReferenceBar._x+5) mcTitle.bAvance = false;
		if(mcTitle._x<mcReferenceBar._width-mcTitle._width-5) mcTitle.bAvance = true;			
	}
}

function joueUnTrack()
{
	sndMonTrack = new Sound();
	sndMonTrack.loadSound(aMesTracks[nIndexTrack].url,true);
	sndMonTrack.onSoundComplete = function()
	{
		nDuree = undefined;
		buNext.mcSensitive.onRelease();
	}
	afficheLeTitre();
}

function gereLeLoadingEtLaProgression()
{
	if(bXmlCharge)
	{
		mcLoadingBar._width = sndMonTrack.getBytesLoaded()/sndMonTrack.getBytesTotal()*mcReferenceBar._width;
		if(sndMonTrack.getBytesLoaded()==sndMonTrack.getBytesTotal())
		{
			mcProgressBar._width = sndMonTrack.getPosition()/sndMonTrack.getDuration()*mcReferenceBar._width;
		}
		else
		{
			mcProgressBar._width = 0;
		}
	}
	else
	{
		mcLoadingBar._width = mcReferenceBar._width;
	}
}



function initMzMd()
{
	var cptB:Number;
	for(cptB=0;cptB<aMesBoutonsDeControl.length;cptB++)
	{
		var mc:MovieClip = aMesBoutonsDeControl[cptB];
		mc.mcSensitive._alpha = 0;
		colorize(mc.mcSymbolColor,sMaCouleurDeTrais);
		colorize(mc.mcFilledColor,sMaCouleurDeTrais);
		mc.mcSensitive.onRollOver = function()
		{
			 jeClignotte(this._parent.mcSymbolColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);
			 jeClignotte(this._parent.mcFilledColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);
		}
		mc.mcSensitive.onRollOut = function()
		{
			 jeClignotte(this._parent.mcSymbolColor,sMaCouleurDeTrais);
			 jeClignotte(this._parent.mcFilledColor,sMaCouleurDeTrais);
		}
	}
	
	var cptS:Number;
	for(cptS=0;cptS<aMesStyles.length;cptS++)
	{
		var mc:MovieClip = mcStyleButtons["buStyle"+cptS];
		mc.mcSensitive._alpha = 0;
		colorize(mc.mcSymbolColor,sMaCouleurDeTrais);
		colorize(mc.mcFilledColor,sMaCouleurDeTrais);
		mc.mcSensitive.onRollOver = function()
		{
			 jeClignotte(this._parent.mcSymbolColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);
			 jeClignotte(this._parent.mcFilledColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);
			this._parent.swapDepths(this._parent._parent.getNextHighestDepth());
		}
		mc.mcSensitive.onRollOut = function()
		{
			 jeClignotte(this._parent.mcSymbolColor,sMaCouleurDeTrais);
			 jeClignotte(this._parent.mcFilledColor,sMaCouleurDeTrais);
			mcBoutonDeStyleEnCours.swapDepths(this._parent._parent.getNextHighestDepth());
		}
		mc.mcSensitive.onRelease = function()
		{
			mcBoutonDeStyleEnCours.mcSensitive.enabled = true;
			jeClignotte(mcBoutonDeStyleEnCours.mcSymbolColor,sMaCouleurDeTrais);
			jeClignotte(mcBoutonDeStyleEnCours.mcFilledColor,sMaCouleurDeTrais);
			mcBoutonDeStyleEnCours = this._parent;
			mcBoutonDeStyleEnCours.mcSensitive.enabled = false;
			jeClignotte(mcBoutonDeStyleEnCours.mcSymbolColor,"000000",sMaCouleurDeTrais,true);
			jeClignotte(mcBoutonDeStyleEnCours.mcFilledColor,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);		
			////////////////////////////////////////////////////
			var sMonStyleVoulu:String = aMesStyles[this._parent._name.substr(7)];
			recupereUnXml(sMonUrlDeBaseDeStyle+sMonStyleVoulu);
		}
	}
	
	mcAntiClick.onRelease = function(){Void();};
	mcAntiClick.useHandCursor = false;
	mcAntiClick._alpha = 0;
	mcAntiClick._visible = false;
	
	mcProgressBar._width = 0;
	initLeCycleDeCouleurDesBarres(mcProgressBar,0);
	mcLoadingBar._width = 0;
	initLeCycleDeCouleurDesBarres(mcLoadingBar,5);
	
	buPrev.mcSensitive.onRelease = function()
	{
		nIndexTrack--;
		if(nIndexTrack<0) nIndexTrack = aMesTracks.length-1;
		buPlay.onRelease();
		buPlay.mcSensitive.onRelease();
		joueUnTrack();
	}
	
	buNext.mcSensitive.onRelease = function()
	{
		nIndexTrack++;
		if(nIndexTrack>=aMesTracks.length) nIndexTrack = 0;
		buPlay.mcSensitive.onRelease();
		joueUnTrack();
	}
	
	buStop.mcSensitive.onRelease = function()
	{
		mcTitle.field.text = "PRESS PLAY ON TAPE";
		sndMonTrack.stop();
		nPosition = sndMonTrack.getPosition();
		gestionBoutonPlayStopEnCours(this._parent);
	}
	
	buPlay.mcSensitive.onRelease = function()
	{
		afficheLeTitre();
		sndMonTrack.start(nPosition/1000);
		gestionBoutonPlayStopEnCours(this._parent);
	}
	
	mcTitle.field.text = "";
	
	jeClignotte(mcOnAir,sMaCouleurDeClignottement ,sMaCouleurDeTrais,true);
	
	colorize(mcTrais,sMaCouleurDeTrais);
	
	this.onEnterFrame = function()
	{
		 faitBougerLeTitre();
		 gereLeLoadingEtLaProgression();
		 calculeLeCycleDeClignottement();
		 calculeLeCycleDeCouleurDesBarres(mcProgressBar);
		 calculeLeCycleDeCouleurDesBarres(mcLoadingBar);
	}
	
}

if(cc!=undefined&&cc!="")
{
	sMaCouleurDeClignottement  = cc;
}
else
{
	sMaCouleurDeClignottement  = aMaPalette[2];
}

if(ct!=undefined&&ct!="")
{
	sMaCouleurDeTrais  = ct;
}
else
{
	sMaCouleurDeTrais  = "FFFFFF";
}

initMzMd();

if(ub!=undefined&&ub!="")
{
	sMonUrlDeBaseDeStyle = ub;
	if(ulst!=undefined&&ulst!="")
	{
		sMonUrlDePlaylist = ulst;
		recupereUnXml(sMonUrlDePlaylist);
	} else {
		var mcStyleRandom:MovieClip = mcStyleButtons["buStyle"+random(aMesStyles.length)];
		mcStyleRandom.mcSensitive.onRelease();
		mcStyleRandom.swapDepths(mcStyleRandom._parent.getNextHighestDepth());
	}	
} else {
	mcTitle.field.text = "the XML base url is empty, i can't do anythin' for you... sorry sorry...";
	mcTitle.field.autoSize = "Left";
	mcTitle.bAvance = true;
	mcAntiClick._visible = true;
}

function lanceUnePlayliste(str:String):Void {
	sMonUrlDePlaylist = str;
	mcBoutonDeStyleEnCours.mcSensitive.enabled = true;
	jeClignotte(mcBoutonDeStyleEnCours.mcSymbolColor,sMaCouleurDeTrais);
	jeClignotte(mcBoutonDeStyleEnCours.mcFilledColor, sMaCouleurDeTrais);
	recupereUnXml(sMonUrlDePlaylist);
	txt.text = str;
}
ExternalInterface.addCallback("parleAvecFlash", null, lanceUnePlayliste);

if(db == "true") 
{
	dbTxt.text = "mode dedug à la porc...";
	dbTxt.text += "\n cc:" + cc;
	dbTxt.text += "\n ct:" + ct;
	dbTxt.text += "\n ub:" + ub;
	dbTxt.text += "\n ulst:" + ulst;
}
else
{
	dbTxt._visible = false;
}

function shuffle(a,b):Number {
	var num : Number = Math.round(Math.random()*2)-1;
	return num;
}
