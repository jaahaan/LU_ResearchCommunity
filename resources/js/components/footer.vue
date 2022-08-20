<template>
    <footer>
        <h4 class="title">Contact Us</h4>
        <div class="footer__text">
            <address>
                Leading University<br />
                Ragibnagar, South Surma, Sylhet-3112
            </address>
            <a
                class="ga-events"
                data-eventcategory="Phone track footer"
                data-eventaction="Click to call"
                data-eventlabel="01759486292"
                href="tel:01759486292"
                ><i class="fa-solid fa-phone"></i> 01759486292</a
            >
            -
            <a
                class="ga-events"
                data-eventcategory="Mail from footer"
                data-eventaction="Click to action"
                data-eventlabel="info@lurc.ac.bd"
                href="mailto:info@lurc.ac.bd"
                >info@lurc.ac.bd</a
            >
            <br />
            <br />
            <a href="/privacy.html" target="_blank">Privacy policy</a> -
            <a
                class="ga-events"
                data-eventcategory="Credits link"
                data-eventaction="Click to action"
                data-eventlabel="https://www.linkedin.com/in/giacomo-mottin-bb38bba0/"
                href="https://www.linkedin.com/in/giacomo-mottin-bb38bba0/"
                target="_blank"
                rel="noopener"
                >Credits</a
            >
            <div>
                <a class="icon" href="www.lus.ac.bd"
                    ><i class="fa-brands fa-google"></i
                ></a>
                <a
                    class="icon"
                    href="https://www.facebook.com/leadinguniversity2001/"
                    ><i class="fa-brands fa-facebook"></i
                ></a>
                <a
                    class="icon"
                    href="https://www.youtube.com/channel/UC3UkVH9fhmQQCKSzQAMRwWA"
                    ><i class="fa-brands fa-youtube"></i
                ></a>
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    name: "Footer",

    data() {
        return {};
    },
    components: {},
    methods: {},
    async created() {},
};
</script>

<style>
footer {
    position: relative;
    padding: 15px;
    background: #3a4660;
    text-align: center;
}
.footer_text {
    font-size: 13px;
    line-height: 15px;
    color: #ed8a63;
}

a {
    color: #c9af98;
    text-decoration: none;
}
a:hover {
    color: #eeecea;
}
address {
    color: #faf3d3;
}
.icon {
    padding: 10px;
    color: #faf3d3;
}
.icon:hover {
    color: #845007;
}
</style>
