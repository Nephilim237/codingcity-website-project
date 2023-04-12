import axios from "axios";

export default class Like {
    constructor(likeElements) {
        this.likeElements = likeElements

        if (this.likeElements) {
            this.init();
        }
    }

    init() {
        this.likeElements.map(element => {
            element.addEventListener('click', this.handleLike)
        })
    }

    handleLike(event) {
        event.preventDefault();
        const url = this.href;

        axios.get(url).then(response => {
            const numberOfLikes = response.data.numberOfLikes;
            const span = this.querySelector('span');
            this.dataset.number_of_likes = numberOfLikes;
            numberOfLikes < 10 ? span.innerHTML = `0${numberOfLikes} j'aime` : span.innerHTML = `${numberOfLikes} j'aime`
            const liked = this.querySelector('i.fa-solid');
            const unliked = this.querySelector('i.fa-regular');
            liked.classList.toggle('d-none');
            unliked.classList.toggle('d-none');
        })
    }
}