
//----------------- element stream -------------------------//

let photos = document.getElementById('photos');
let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let ctx = canvas.getContext('2d');
let img = new Image();
let size = [0.6];
let setoffX = [0];
let setoffY = [0];
let width = canvas.width;
let height = canvas.height;
let filterTab = [];
let fifi = 0;
let camm = 0;
let imgthis = new Image();

//----------------- media stream-------------------------//
function camOn() {
	if (camm === 0 || camm === 1) {

		navigator.getMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia);
		//contrainte
		navigator.getMedia({
			video: true,
			audio: false
		},

			function (stream) {
				if (camm === 0) {
					// activer la cam
					//appelle reussi
					if (navigator.mozGetUserMedia) {
						video.srcObject = stream;
					} else {
						video.srcObject = stream;
					}
					video.play();
					camm = 1;
				} else {
					//désactiver la cam
					if (navigator.mozGetUserMedia) {
						video.srcObject = stream;
					} else {
						video.srcObject = stream;
					}
					stopStreamedVideo(video);
					camm = 0;
					ctx.clearRect(0, 0, width, height);
				}
			},
			//erreur
			function (err) {
				return (-1);
			}
		);
	}
}

//----------------- fichier téléchargeable-------------------------//

document.getElementById('inputGroupFile02').onchange = function (e) {
	if (camm === 0) {
		var img = new Image();

		if (this.files[0].type == "image/png" || this.files[0].type == "image/PNG" || this.files[0].type == "image/jpeg" || this.files[0].type == "image/JPEG") {
			img.onload = draw;
			img.onerror = failed;
			img.src = URL.createObjectURL(this.files[0]);
			imgthis = img;
			fifi = this.files[0];
		} else {

			alert("Les format accepter sont les png et les jpg.");
		}
	} else {
		alert("Il faut arrêter la caméra pour pouvoir charger une photo");
	}
};

function draw() {

	ctx.drawImage(this, 0, 0, width, height);
}

function failed() {
	console.error("The provided file couldn't be loaded as an Image media");
}
//-------------stop stream--------///
function stopStreamedVideo(videoElem) {
	//rcup stream  
	let stream = videoElem.srcObject; //on recup src video;
	//tab[] des flux de stream 
	let tracks = stream.getTracks(); //

	tracks.forEach(function (track) {
		//on arrete le flux 
		track.stop();
	});
	//on met la src a null
	videoElem.srcObject = null;
}


document.addEventListener("load", updateCanvas());


//----------- mettre à jour  canvas-------------------------//
function updateCanvas() {
	ctx.drawImage(video, 0, 0, width, height);
	drawFilter();
	setTimeout(updateCanvas, 10);
}

//----------------add filtre--------------------//
function addFilter(idFilter) {
	filterTab.push(idFilter);
}


//---------------superpose filtre---------------------//
function drawFilter() {
	filterTab.forEach(function (filter) {
		ctx.drawImage(document.getElementById(filter), 0, 0, width, height);
	})

}
//----------------del filtre--------------------//

function deleteFilter() {
	if (filterTab != null) {
		filterTab.pop();
	}
	if (camm == 0 && fifi == 0) {
		// clearRect supprimant tout contenu précédemment dessiné

		ctx.clearRect(0, 0, width, height);
	}
	if (fifi != 0) {
		//ne pas perdre la photo
		ctx.drawImage(imgthis, 0, 0, width, height);
	}
}

//-------------del les photos-----------------------//
function clearButton() {
	photos.innerHTML = '';
}

//---------------crée id---------------------//

function idPicture() {
	let d = Math.random();
	return (d);
}

//-------------creat element -----------------------//

function takePicture() {
	if (camm === 1) {
		//creation string
		let id = idPicture().toString();
		//creation div
		let div = document.createElement('div');
		div.setAttribute('class', 'image');
		div.setAttribute('id', id);
		//creat image
		let imgUrl = canvas.toDataURL('image/png');
		let img = document.createElement('img');
		img.setAttribute('src', imgUrl);
		img.setAttribute('class', id);
		img.setAttribute('id', id);
		img.setAttribute('name', 'photo');
		//creat button
		let btn = document.createElement('button');
		btn.innerHTML = 'Sauvegarder';
		btn.setAttribute('id', id);
		btn.setAttribute('class', 'btnprimary');
		btn.setAttribute('onclick', 'savePicture(id)');
		//generate elemnt in dom
		div.appendChild(img);
		div.appendChild(btn);
		//generate total child in div photo
		photos.appendChild(div);
		// console.log(canvas.nodeValue);

	} else if (fifi != 0) {
		let id = idPicture().toString();
		//creé div
		let div = document.createElement('div');
		div.setAttribute('class', 'image');
		div.setAttribute('id', id);
		//creé image
		let imgUrl = canvas.toDataURL('image/png');
		let img = document.createElement('img');
		img.setAttribute('src', imgUrl);
		img.setAttribute('class', id);
		img.setAttribute('id', id);
		img.setAttribute('name', 'photo');
		//crée button
		let btn = document.createElement('button');
		btn.innerHTML = 'Sauvegarder';
		btn.setAttribute('id', id);
		btn.setAttribute('class', 'btnprimary');
		btn.setAttribute('onclick', 'savePicture(id)');
		//generate elemnt in dom
		div.appendChild(img);
		div.appendChild(btn);
		//generate total child in div photo
		photos.appendChild(div);
		// console.log(canvas);

	} else if (fifi === 20) {

	} else {
		// console.log(canvas);
	}

}

//----------------sendelement--------------------//

function savePicture(id) {
	//cree la req
	var xhr = new XMLHttpRequest();
	//recup img
	var imgdata = document.getElementsByClassName(id);
	var data = new FormData();
	//on recup src img et on met sa dans imgdata et imageData c'est le input 
	data.append('imageData', imgdata.photo.currentSrc);
	//verif satus req
	xhr.onreadystatechange = function () {
		if (xhr.readyState === 4) {
			if (xhr.status === 200) {
				var element = document.getElementById(id);
				element.parentElement.removeChild(element);
			} else
				console.log('error');
		}
	}
	//on envoie a captur
	xhr.open('post', '../controleur/capture.php', true);
	//on envoie les donner sav dans data
	xhr.send(data);
}