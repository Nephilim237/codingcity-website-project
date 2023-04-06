window.onload = () => {
    // Select Body
    const bodyEle = document.body;

    // Select Switch Toggle
    const switchToggleDash = document.querySelector('.toggle-switch');

    // When (switchToggle) has (click) Event
    switchToggleDash.addEventListener('click', function () {
        // Toggle Class (body_theme_light) On (bodyEle)
        bodyEle.classList.toggle('body_theme_light');
    });


    //Sidebar JS
    function $(selector) {
        return document.querySelector(selector)
    }

    function find(el, selector) {
        let finded
        return (finded = el.querySelector(selector)) ? finded : null
    }

    function siblings(el) {
        const siblings = []
        for (let sibling of el.parentNode.children) {
            if (sibling !== el) {
                siblings.push(sibling)
            }
        }
        return siblings
    }

    const showAsideBtn = $('.show-side-btn')
    const sidebar = $('.sidebar')
    const wrapper = $('#wrapper')

    showAsideBtn.addEventListener('click', function () {
        $(`#${this.dataset.show}`).classList.toggle('show-sidebar')
        wrapper.classList.toggle('fullwidth')
    })

    if (window.innerWidth < 767) {
        sidebar.classList.add('show-sidebar');
    }

    window.addEventListener('resize', function () {
        if (window.innerWidth > 767) {
            sidebar.classList.remove('show-sidebar')
        }
    })

// dropdown menu in the side nav
    let slideNavDropdown = $('.sidebar-dropdown');

    $('.sidebar .cc-categories').addEventListener('click', function (event) {
        if (slideNavDropdown.contains(event.target)) {
            event.target.click()
        }

        const item = event.target.closest('.has-dropdown')

        if (!item) {
            return
        }

        item.classList.toggle('opened')

        siblings(item).forEach(sibling => {
            sibling.classList.remove('opened')
        })

        if (item.classList.contains('opened')) {
            const toOpen = find(item, '.sidebar-dropdown')

            if (toOpen) {
                toOpen.classList.add('active')
            }

            siblings(item).forEach(sibling => {
                const toClose = find(sibling, '.sidebar-dropdown')

                if (toClose) {
                    toClose.classList.remove('active')
                }
            })
        } else {
            find(item, '.sidebar-dropdown').classList.toggle('active')
        }
    })

    $('.sidebar .close-aside').addEventListener('click', function () {
        $(`#${this.dataset.close}`).classList.add('show-sidebar')
        wrapper.classList.remove('margin')
    })

    //Floating action button
    function deployFabButtons() {
        const mainFab = document.querySelector('.main-fab');
        const fabContent = document.querySelector('.cc-fab-content');

        mainFab.addEventListener('click', () => {
            let fabs = document.querySelectorAll('.sub-fab-buttons');
            const margin_bottom = 16;
            const sub_fab = 36;
            if (!mainFab.classList.contains('open')) {
                fabs.forEach((fab, index) => {
                    let translate_value = -(48 + (sub_fab + margin_bottom) * index);
                    fab.style.marginBottom = margin_bottom + "px";
                    fab.style.transform = `translateY(${translate_value}px)`;
                    fab.style.transition = `transform 100ms ease-out`;
                });
                mainFab.classList.add('open');
                fabContent.classList.add('fab-overlay')
            } else {
                fabs.forEach((fab, index) => {
                    fab.style.marginBottom = 0 + "px";
                    fab.style.transform = `translateY(0px)`;
                    fab.style.transition = `transform 100ms ease-out`;
                });
                mainFab.classList.remove('open');
                fabContent.classList.remove('fab-overlay')
            }
        })
    }

    deployFabButtons();

}
