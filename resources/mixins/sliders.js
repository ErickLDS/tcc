export default {
    name: "Sliders",
    data () {
        return {
            sliders: [],
            sliderAtual: 0,
        }
    },
    methods: {

        // Pega todos os sliders e armazena
        getSliders () {
            this.sliders = document.querySelectorAll(".slider__item");
            this.sliders[0].classList.add('active');
        },

        // Muda para o próximo slider
        sliderProximo () {
            this.sliderAtual++;
            this.resetarSliders();
            this.sliders[this.sliderAtual].classList.add("active");
            document.querySelector('#slider').scrollIntoView(true);
        },

        // Muda para o slider anterior
        sliderAnterior () {
            this.sliderAtual -= 1;
            this.resetarSliders();
            this.sliders[this.sliderAtual].classList.add("active");
            document.querySelector('#slider').scrollIntoView(true);
        },

        // Reseta os sliders
        resetarSliders () {
            this.sliders.forEach((e) => {
                e.classList.remove("active");
            });
        },
    }
}