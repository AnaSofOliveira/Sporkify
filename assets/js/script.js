function Audio(){

    this.currentyPlaying;
    this.audio = document.createElement("audio"); 

    this.setTrack = function(src){
        this.audio.src = src;
    } 

}