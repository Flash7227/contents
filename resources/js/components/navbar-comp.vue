<template>
    <div>
        <nav class="navbar">
            <!-- LOGO -->
            <div class="logo">MUO</div>
            <!-- NAVIGATION MENU -->
            <ul class="nav-links">
                <!-- USING CHECKBOX HACK -->
                <input type="checkbox" id="checkbox_toggle" />
                <label for="checkbox_toggle" class="hamburger_fdf"
                    >&#9776;</label
                >
                <!-- NAVIGATION MENUS -->
                <div class="menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/">About</a></li>
                    <li class="services">
                        <a href="/">Services</a>
                        <!-- DROPDOWN MENU -->
                        <ul class="dropdown">
                            <li><a href="/">Dropdown 1 </a></li>
                            <li><a href="/">Dropdown 2</a></li>
                            <li><a href="/">Dropdown 2</a></li>
                            <li><a href="/">Dropdown 3</a></li>
                            <li><a href="/">Dropdown 4</a></li>
                        </ul>
                    </li>
                    <li><a href="/">Pricing</a></li>
                    <li><a href="/">Contact</a></li>
                </div>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
        };
    },
    methods: {
        spinStart() {
            this.$Spin.show({
                render: (h) => {
                    return h("div", [
                        h("Icon", {
                            class: "demo-spin-icon-load",
                            props: {
                                type: "ios-loading",
                                size: 38,
                            },
                        }),
                        h("div", "Loading"),
                    ]);
                },
            });
        },
        fetch() {
            this.spinStart();
            axios
                .get("/test")
                .then((response) => {
                    this.$Spin.hide();
                })
                .catch((error) => {
                    this.loading = false;
                    console.log(error.response);
                    this.$notify.error({
                        title: "Error",
                        message: error.response.data.message,
                    });
                });
        },
    },
    created() {
        // this.fetch();
    },
};
</script>
<style scoped>
/* UTILITIES */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
    font-family: cursive;
}
a {
    text-decoration: none;
}
li {
    list-style: none;
}
/* NAVBAR STYLING STARTS */
.navbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    background-color: teal;
    color: #fff;
}
.nav-links a {
    color: #fff;
}
/* LOGO */
.logo {
    font-size: 32px;
}
/* NAVBAR MENU */
.menu {
    display: flex;
    gap: 1em;
    font-size: 18px;
}
.menu li:hover {
    background-color: #4c9e9e;
    border-radius: 5px;
    transition: 0.3s ease;
}
.menu li {
    padding: 5px 14px;
}
/* DROPDOWN MENU */
.services {
    position: relative;
}
.dropdown {
    background-color: rgb(1, 139, 139);
    padding: 1em 0;
    position: absolute; /*WITH RESPECT TO PARENT*/
    display: none;
    border-radius: 8px;
    top: 35px;
}
.dropdown li + li {
    margin-top: 10px;
}
.dropdown li {
    padding: 0.5em 1em;
    width: 8em;
    text-align: center;
}
.dropdown li:hover {
    background-color: #4c9e9e;
}
.services:hover .dropdown {
    display: block;
}
</style>
