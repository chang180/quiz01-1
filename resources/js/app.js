require('./bootstrap');

import { createApp } from 'vue'


const app = {
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
    methods: {
        switchImg(type) {
            let imgs = this.images.data
            let page = this.images.page
            switch (type) {
                case 'up':
                    page = (page > 0) ? page - 1 : page
                    break
                case 'down':
                    page = (page < imgs.length - 3) ? page + 1 : page
                    break
            }
            imgs.map((img, idx) => {
                if (idx >= page && idx <= page + 2) {
                    img.show = true
                } else {
                    img.show = false
                }
                return img
            })
            this.images.data = imgs
            this.images.page = page
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
    // mounted(){
    //     this.switchImg('up')
    // }
}

createApp(app).component('marquee', {
    // props: ['text'],
    template: `
                                <div class="relative w-100 h-8 overflow-hidden" ref="marquee">
                                <div class="absolute w-max" ref="content">
                                <slot></slot>
                                </div>
                                </div>            
                                `,
    mounted() {
        let marquee = this.$refs.marquee.offsetWidth
        let content = this.$refs.content.offsetWidth
            // console.log(marquee, content)
        this.$refs.content.style.right = (0 - content) + "px"
        let pos = 0 - content
        setInterval(() => {
            pos++
            this.$refs.content.style.right = pos + "px"
            if (pos >= marquee) pos = 0 - content
        }, 15);
    }
}).mount('#app')