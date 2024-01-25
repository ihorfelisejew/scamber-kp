const headMenuItems = document.querySelectorAll('.menu__item');
headMenuItems.forEach((item, index) => {
    item.addEventListener('click', function() {
        headMenuItems.forEach((itemInclude, indexInclude)=>{
            itemInclude.classList.remove('menu__active');
            if(index == indexInclude){
                item.classList.add('menu__active');

                const hrefFromMenu = item.querySelector('.menu__link').getAttribute('href');
                const containerElements = document.querySelector('.content__container').querySelectorAll('section');
                containerElements.forEach(section => {
                    section.classList.remove('non-active__content');
                    console.log(section.getAttribute('id') + " " + hrefFromMenu);
                    if("#"+section.getAttribute('id') !== hrefFromMenu){
                        section.classList.add('non-active__content');
                    }
                });
            }
        })
    })
})