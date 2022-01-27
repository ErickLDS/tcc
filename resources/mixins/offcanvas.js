export default {
    name: 'Offcanvas',
    data () {
        return {
            
        }
    },
    methods: {

        // Abre um Offcanvas especificado
        openOffcanvas (selector) {
            document.querySelector(".offcanvas#"+selector).classList.add("active");
            document.querySelector(".offcanvas__backdrop").classList.add("active");
        }, 
        
        // Fecha todos os Offcanvas
        closeOffcanvas () {
            let elementos = document.querySelectorAll(".offcanvas");
            elementos.forEach((e) => {
                e.classList.remove("active");
            });

            document.querySelector(".offcanvas__backdrop").classList.remove("active");
        },
    }
}