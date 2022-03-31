window.onload = () => {
    
    // Check the progress lesson
    function onClickBtnCheck(event) {
        event.preventDefault();
        
        const url = this.href;
        const id = this.id;
    
        const icon = document.querySelector('img.check'+id);
        
        fetch(url)
            .then(response => response.json())
            .then(data => icon.src = data.src);
    }

    document.querySelectorAll('a.js-check').forEach(function(link) {
        link.addEventListener('click', onClickBtnCheck);
    })

    // Show the lesson content
    function onClickBtnWatch(event) {
        event.preventDefault();
        
        const url = this.href;
        const title = document.querySelector('p.title');
        const explanation = document.querySelector('p.explanation');
        const video = document.querySelector('div.video');
    
        fetch(url)
            .then(response => response.json())
            .then(function(data) {
                title.textContent = data.lessonTitle;
                video.innerHTML = data.lessonVideo;
                explanation.textContent = data.lessonExplanation;
            });
    }

    document.querySelectorAll('a.watch').forEach(function(link) {
        link.addEventListener('click', onClickBtnWatch);
    })

    // Search Keyup
    function searchKeyUp() {
        
        const searchUrl = window.location.href;
        const input = document.querySelector('input.search').value;

        fetch(searchUrl + "?ajax=1" + "&value=" + input, {
            headers: {
                "x-Requested-With": "XMLHttpRequest"
            }
        }).then(response => response.json())
        .then(data => {
            const content = document.querySelector('#content');
            content.innerHTML = data.content;
        })
        .catch(e => alert(e));
    }

    const search = document.querySelector('input.search');
    search.addEventListener('keyup', searchKeyUp);
    


}