<template>
    <div class="h-25">
        <div class="text-center py-2 border-bottom my-1">
            {{ title }}
            <router-link class="float-right" :to="more.href" v-if="more.show"
                >More...</router-link
            >
        </div>
        <ul class="list-group">
            <li
                class="list-group-item list-gorup-item-action p-1 new"
                v-for="(ns, idx) of news"
                @mouseover="ns.show = true"
                @mouseleave="ns.show = false"
                :key="ns.id"
            >
                {{ paginate.start + idx + ". " + ns.short }}
                <div
                    class="border border-dark rounded-shadow text-white offset-4 w-75 bg-secondary text-5 position-absolute"
                    style="z-index: 1"
                    v-show="ns.show"
                >
                    <pre class="text-white" v-html="ns.text"></pre>
                </div>
            </li>
        </ul>
        <div class="d-flex justify-center p-2" v-if="paginate.show">
            <a
                class="d-block p-1 border"
                href="#"
                @click="page(paginate.prev)"
                v-if="paginate.prev > 0"
            >
                &lt;
            </a>
            <a
                class="d-block p-1 border self-center"
                :class="paginate.font[p]"
                href="#"
                @click="page(p)"
                v-for="(p, idx) of paginate.links"
                :key="idx"
            >
                {{ p }}
            </a>
            <a
                class="d-block p-1 border"
                href="#"
                @click="page(paginate.next)"
                v-if="paginate.next > 0"
            >
                &gt;
            </a>
        </div>
    </div>
</template>
<script>
import { ref, onMounted, reactive, watch } from "vue";
export default {
    props: ["route"],
    setup(props) {
        // console.log(props.news.more);
        const title = ref("最新消息");
        const news = ref(new Array());
        const more = ref({});
        const paginate = reactive({
            total: 0,
            div: 5,
            links: [],
            items: [],
            prev: 0,
            next: 0,
            pages: 0,
            start: 1,
            font: [],
            show: false,
        });
        const page = (p) => {
            paginate.prev = p - 1 > 0 ? p - 1 : 0;
            paginate.next = p + 1 <= paginate.pages ? p + 1 : 0;
            paginate.start = (p - 1) * paginate.div + 1;
            paginate.font = [];
            paginate.font[p] = "text-xl";

            news.value = paginate.items.filter((item, idx) => {
                if (idx + 1 >= paginate.start && idx + 1 <= p * paginate.div) {
                    return item;
                }
            });
        };

        const changeRoute = () => {
            switch (props.route) {
                case "index":
                    title.value = "最新消息區";
                    paginate.show = false;
                    break;
                case "news":
                    title.value = "更多最新消息區";
                    //   props.news.more.show = false;
                    break;
            }
            axios.get(`api/news/${props.route}`).then((res) => {
                news.value = res.data.news;
                more.value = res.data.more;
                if (res.data.news.length > 5) {
                    paginate.total = res.data.news.length;
                    paginate.pages = Math.ceil(paginate.total / paginate.div);
                    paginate.items = res.data.news;
                    paginate.links.length = 0;
                    for (let i = 1; i <= paginate.pages; i++) {
                        paginate.links.push(i);
                    }
                    // console.log(paginate)
                    paginate.show = true;
                    page(1);
                }
            });
        };

        watch(props, (old, newer) => {
            changeRoute();
        });

        onMounted(() => {
            changeRoute();
        });
        return {
            title,
            props,
            news,
            more,
            paginate,
            page,
        };
    },
};
</script>
