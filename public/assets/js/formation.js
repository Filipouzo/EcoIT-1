window.onload = () => {

    function onClickBtnCheck(event) {
        event.preventDefault();
        
        const url = this.href;
        
        const icon = document.querySelector('img.icon-lesson');
        

        fetch(url)
            .then(response => response.json())
            .then(data => icon.src = data.src);
    }

    document.querySelectorAll('a.js-check').forEach(function(link) {
        link.addEventListener('click', onClickBtnCheck);
    })

    function onClickBtnWatch(event) {
        event.preventDefault();
        
        const url = this.href;
        const p = document.querySelector('p.test');
        const pp = document.querySelector('p.test1');
        const video = document.querySelector('div.video');
    
        fetch(url)
            .then(response => response.json())
            .then(function(data) {
                p.textContent = data.lessonTitle;
                pp.textContent = data.lessonExplanation;
                video.innerHTML = data.lessonVideo;
            });
    }

    document.querySelectorAll('a.watch').forEach(function(link) {
        link.addEventListener('click', onClickBtnWatch);
    })

    


}