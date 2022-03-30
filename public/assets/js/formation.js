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
    function searchKeyUp(search) {
        
        const searchKey = search.key;
        const searchUrl = window.location.href;
        const searchImage = document.querySelector('img.search');
        const searchTitle = document.querySelector('h2.search');
        const searchDes = document.querySelector('div.search');

        fetch(searchUrl + "?keyup=" + searchKey + "&ajax=1")
            .then(response => response.json())
            .then(data => {
                searchTitle.innerHTML = data.title;
                searchImage.src = data.image;
                searchDes.innerHTML = data.explanation;
            })
            .catch(e => alert(e));            
            // .then(function(data) {
            //     searchTitle.textContent = data.searchTitle;
            //     searchImage.src = data.searchImage;
            //     searchDes.textContent = data.searchDes;
            // });
    }

    const search = document.querySelector('input.search');
    search.addEventListener('keyup', searchKeyUp);
    


}