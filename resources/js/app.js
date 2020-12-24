require('./bootstrap');

import { createApp } from 'vue'
import Marquee from './components/Marquee.vue'
import Images from './components/Images.vue'


const app = {
    components: { 'marquee': Marquee, 'images': Images },

    data() {

        return {
            menus: null,
            images: null,
            mvims: null,
            newss: null,
            site: null,
            show: false,
        }
    },

    mounted() {
        axios.get("/api")
            .then((res) => {
                // console.log(res.data)
                this.site = res.data.site
                this.menus = res.data.menus
                this.images = res.data.images
                this.newss = res.data.news
                this.mvims = res.data.mvims
                this.show = true
            })
        let m = 1
        setInterval(() => {
            this.mvims.map((mv, idx) => {
                mv.show = (idx == m) ? true : false
                return mv
            })
            m = (m + 1) % this.mvims.length
        }, 3000);
    }
}

createApp(app).mount('#app')