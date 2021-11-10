<!DOCTYPE html>
<html>
  <head>
  <script type="text/javascript" src="exp.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <link rel="stylesheet" href="exp.css" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">


  
  </head>

<body>




<nav class="navbar navbar-light">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="#">Navbar</a> -->
    <button onclick="playVid()" type="button" id='play' class="btn btn-info">Play Video</button>
    
  </div>
</nav>



<!-- <button id="btnStop">STOP RECORDING</button></p> -->

<video id="myVideo" autoplay width="70%" id="video">
  <source src="How_Recommender_Systems_Work.mp4" type="video/mp4">

<!-- <video id="vid4" controls></video>
<video id="vid5" controls></video>
<video id="vid6" controls></video> -->

Your browser does not support the video tag.
</video>
<h2>Record videos</h2>


<video id="vid2" width="30%" controls></video>

<video id="vid3" width="30%" controls></video>

<video id="vid4" width="30%" controls></video>
<video id="vid5" width="30%" controls></video>
<video id="vid6" width="30%" controls></video>
<video id="vid7" width="30%" controls></video>
<video id="vid8" width="30%" controls></video>
<script>
  // https://usefulangle.com/post/354/javascript-record-video-from-camera
// let start_button = document.querySelector("#play");
// let camera_stream = null;
// let media_recorder = null;
// let blobs_recorded = [];



// start_button.addEventListener('click', function() {
//     // set MIME type of recording as video/webm
//     media_recorder = new MediaRecorder(camera_stream, { mimeType: 'video/webm' });

//     // event : new recorded video blob available 
//     media_recorder.addEventListener('dataavailable', function(e) {
// 		blobs_recorded.push(e.data);
//     });





// document.getElementById("submit").disabled = true;
// frontcam
let constraintObj = { 
            audio: false, 
            video: { 
                facingMode: "user", 
                width: { min: 640, ideal: 1280, max: 1920 },
                height: { min: 480, ideal: 720, max: 1080 } 
            } 
        }; 
        // width: 1280, height: 720  -- preference only
        // facingMode: {exact: "user"}
        // facingMode: "environment"
        
//handle older browsers that might implement getUserMedia in some way
if (navigator.mediaDevices === undefined) {
    navigator.mediaDevices = {};
    navigator.mediaDevices.getUserMedia = function(constraintObj) {
        let getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
        if (!getUserMedia) {
            return Promise.reject(new Error('getUserMedia is not implemented in this browser'));
        }
        return new Promise(function(resolve, reject) {
            getUserMedia.call(navigator, constraintObj, resolve, reject);
        });
    }
}else{
    navigator.mediaDevices.enumerateDevices()
    .then(devices => {
        devices.forEach(device=>{
            console.log(device.kind.toUpperCase(), device.label);
            //, device.deviceId
        })
    })
    .catch(err=>{
        console.log(err.name, err.message);
    })
}

navigator.mediaDevices.getUserMedia(constraintObj)
.then(function(mediaStreamObj) {
    //connect the media stream to the first video element
    // let video2 = document.querySelector('video');
    
    let video2 = document.querySelector("#vid2");
    if ("srcObject" in video2) {
        video2.srcObject = mediaStreamObj;
    } else {
        //old version
        video2.src = window.URL.createObjectURL(mediaStreamObj);
    }
    
    video2.onloadedmetadata = function(ev) {
        //show in the video element what is being captured by the webcam
        video2.play();
    };

//add listeners for saving video/audio
let start = document.getElementById('play');
let stop = document.getElementById('btnStop');
let vidSave = document.getElementById('vid3');
let mediaRecorder = new MediaRecorder(mediaStreamObj);
let chunks = [];
var count = 3;
const video = document.getElementById('myVideo');
            
        start.addEventListener('click', (ev)=>{
            mediaRecorder.start();
            console.log(mediaRecorder.state);
        })
        // stop.addEventListener('click', (ev)=>{
        //     mediaRecorder.stop();
        //     console.log(mediaRecorder.state);
        // });
    //     video.addEventListener('timeupdate', function(){
    //       if(this.currentTime >= 5) {
    //     // pause the playback
    //       this.pause();
    //       $("#sub").prop('disabled', false);
    //       pasuedtime = this.currentTime
    //       mediaRecorder.stop();
    // }

        video.onplay = function() {
      
          window.setTimeout(()=>{
            const video = document.getElementById('myVideo');
            video.pause()
            $("#sub").prop('disabled', false);
            mediaRecorder.stop();
            var idtag = 'vid' + count.toString();
            console.log(idtag);
            vidSave = document.getElementById(idtag);
            count += 1;
            // media_recorder.stop(); 
          }, 3000)//6000ms = 6sec
    }
          
          

     
        mediaRecorder.ondataavailable = function(ev) {
            chunks.push(ev.data);
        }
        mediaRecorder.onstop = (ev)=>{
            let blob = new Blob(chunks, { 'type' : 'video/mp4;' });
            chunks = [];
            console.log("stop")
            let videoURL = window.URL.createObjectURL(blob);
            vidSave.src = videoURL;
        }
    })
    .catch(function(err) { 
        console.log(err.name, err.message); 
    });
    
    /*********************************
    getUserMedia returns a Promise
    resolve - returns a MediaStream Object
    reject returns one of the following errors
    AbortError - generic unknown cause
    NotAllowedError (SecurityError) - user rejected permissions
    NotFoundError - missing media track
    NotReadableError - user permissions given but hardware/OS error
    OverconstrainedError - constraint video settings preventing
    TypeError - audio: false, video: false
    *********************************/


const video = document.getElementById('myVideo');
function playVid() { 
  $("#play").prop('disabled', true);
  video.play(); 
} 

$(document).ready(function () {
  $("#sub").click(function () {
      setTimeout(function () { disableButton(); }, 0);
  });

function disableButton() {
    $("#sub").prop('disabled', true);
    var msg = document.getElementById('msg');
  msg.innerHTML = 'Data submitted and the button disabled &#9786;';
  $("#play").prop('disabled', false);
  
}
});

</script>

  <div class='form' >
      <p class="text-center">Answer your needed at this point</p>
     
      <form action="#" method="post" target="frame" id="myForm">
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-179" value="I don't need anything" >
        <!-- <label class="form-check-label" for="radio-179">USD $17,750</label> -->
        <label class="form-check-label" for="radio-179">I don't need anything</label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-279" value="Teach Faster">
        <!-- <label class="form-check-label" for="radio-279">USD $72,800</label> -->
        <label class="form-check-label" for="radio-179">Teach Faster</label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-379" value="Teach slower">
        <label class="form-check-label" for="radio-379">Teach slower</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Wait a moment">
        <label class="form-check-label" for="radio-479">Wait a moment</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Explain one more time">
        <label class="form-check-label" for="radio-479">Explain one more time</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Explain more detail">
        <label class="form-check-label" for="radio-479">Explain more detail</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Take a break">
        <label class="form-check-label" for="radio-479">Take a break</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Want to ask a question">
        <label class="form-check-label" for="radio-479">Want to ask a quesiton</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Make the class more interesting">
        <label class="form-check-label" for="radio-479">Make the class more interesting</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Want to share some thoughts">
        <label class="form-check-label" for="radio-479">Want to share some thoughts</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Hold on, I want to take some notes">
        <label class="form-check-label" for="radio-479">Hold on, I want to take some notes</label>
      </div>

      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="I'm lost, teach me easier thing first">
        <label class="form-check-label" for="radio-479">I'm lost, teach me easier thing first</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Skip this part">
        <label class="form-check-label" for="radio-479">Skip this part</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Go back to the last part">
        <label class="form-check-label" for="radio-479">Go back to the last part</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Relax">
        <label class="form-check-label" for="radio-479">Relax</label>
      </div>
      <div class="form-check mb-2">
        <input class="form-check-input" name="check_list[]" type="checkbox" id="radio-479" value="Give me some example">
        <label class="form-check-label" for="radio-479">Give me some example</label>
      </div>
     
      <!-- Checkbox -->

      <hr>
      <div class="survey-footer clearfix">
      <input type="submit" name="sub" value="Submit" id='sub' disabled>
      <iframe name="frame" style="display:none;"></iframe>
      <p id="msg"></p>

      </div>
</div>
<!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
   
</body>



</html>
<?php

if(isset($_POST['sub'])){//to run PHP script on submit
    if(!empty($_POST['check_list'])){
    
        $fp = fopen("record.csv", "a");
        fputcsv($fp, $_POST['check_list']);
        fclose($fp);

    }
   
}
?>