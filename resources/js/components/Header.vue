<template>
    <div>
        <div class="landing-header-cont">
            <div class="landing-header-left">
                <img
                    @click="toggleNavLinks = !toggleNavLinks"
                    style="display: none"
                    src="/assets/landing_page/Frame_5038.svg"
                    alt=""
                />
                <a style="margin-left: 10px" href="/"
                    ><img
                        @click="window.location = '/'"
                        src="/assets/landing_page/logo.svg"
                        alt=""
                /></a>
            </div>
            <div class="landing-header-middle">
                <a href="/" class="active">HOME</a>
                <a href="/manager-tools">MANAGER TOOLS</a>
                <!--<a href="/directory/vendors/venues">Wedding venues</a>
                <a href="/ideas-and-inspiration">Ideas and inspiration</a>
                <a href="/vendor-directory">Wedding vendors</a>--> 
            </div>
            <div class="landing-header-middle-2">
                <a style="margin-left: 10px" href="/"
                    ><img
                        @click="window.location = '/'"
                        src="/assets/landing_page/logo.svg"
                        alt=""
                /></a>
            </div>
            <div class="landing-header-right">
                <div v-if="loggedIn">
                    <a id="dashboard-btn" :href="href">Dashboard</a>
                    <a
                        id="logout-btn"
                        :href="route('logoutAll')"
                        @click.prevent="logout()"
                        >LOGOUT</a
                    >
                    
                    <a
                        :href="route('logoutAll')"
                        @click.prevent="logout()"
                        style="display: none"
                    >
                        <i
                            style="
                                width: 28px;
                                height: 28px;
                                border-radius: 50%;
                            "
                            class="fas fa-sign-out-alt"
                        ></i>
                    </a>
                    <a :href="href" style="display: none"
                        ><img
                            style="
                                width: 28px;
                                height: 28px;
                                border-radius: 50%;
                            "
                            src="/storage/defaultsv1/avatar.png"
                            alt=""
                    /></a>
                </div>
                <div v-else class="d-flex justify-content-space-around">
                    <a :href="route('hostLogin')"
                        ><img
                            src="/assets/landing_page/ic_round-log-in.svg"
                            alt=""
                        />Host</a
                    >
                    <a :href="route('login')"
                        ><img
                            src="/assets/landing_page/fluent_guest-16-regular.svg"
                            alt=""
                        />Guests</a
                    >
                    <a
                        class="mx-1"
                        :href="route('hostLogin')"
                        style="display: none"
                        ><img
                            src="/assets/landing_page/ic_round-log-in.svg"
                            alt=""
                    /></a>
                    <a class="mx-1" :href="route('login')" style="display: none"
                        ><img
                            src="/assets/landing_page/fluent_guest-16-regular.svg"
                            alt=""
                    /></a>
                </div>
            </div>
        </div>
        <div v-show="toggleNavLinks" class="landing-mobile-links">
            <a href="/" class="landing-mobile-links-single active">
                <div>
                    <img src="/assets/landing_page/2.svg" alt="" />
                </div>
                <p>Home</p>
            </a>
            <a href="/manager-tools" class="landing-mobile-links-single">
                <div>
                    <img src="/assets/landing_page/3.svg" alt="" />
                </div>
                <p>Manager Tools</p>
            </a>
            <!--<a href="/wedding-venues" class="landing-mobile-links-single">
                <div>
                    <img src="/assets/landing_page/4.svg" alt="" />
                </div>
                <p>Wedding Venues</p>
            </a>
            <a
                href="/ideas-and-inspiration"
                class="landing-mobile-links-single"
            >
                <div>
                    <img src="/assets/landing_page/3.svg" alt="" />
                </div>
                <p>Ideas & Insipiration</p>
            </a>-->
            <!-- <a href="/vendor-directory" class="landing-mobile-links-single">
                <div>
                    <img src="/assets/landing_page/2.svg" alt="" />
                </div>
                <p>Directory</p>
            </a> -->
        </div>
        <form
            style="display: none"
            :action="route('logoutAll')"
            method="POST"
            ref="logout"
        >
            <input type="hidden" name="_token" v-bind:value="csrf" />
            <input type="hidden" name="logoutAll" :value="true" />
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            toggleNavLinks: false,
            loggedIn: false,
            href: "#",
            csrf: $('meta[name="csrf-token"]').attr("content"),
        };
    },
    methods: {
        logout() {
            this.$refs.logout.submit();
        },
        activeLink() {
            let path = window.location.pathname.substring(1);
            let finalPath = path.split("/")[0];

            let elements = $(".landing-header-middle > a");
            let mobileEle = $(".landing-mobile-links-single");
            elements.each(function (index, item) {
                $(item).removeClass("active");
            });
            mobileEle.each(function (index, item) {
                $(item).removeClass("active");
            });
            // console.log(finalPath, path);
            if (finalPath == "") {
                $(elements[0]).addClass("active");
                $(mobileEle[0]).addClass("active");
            } else if (finalPath == "manager-tools") {
                $(elements[1]).addClass("active");
                $(mobileEle[1]).addClass("active");
            } else if (finalPath == "wedding-venues") {
                $(elements[2]).addClass("active");
                $(mobileEle[2]).addClass("active");
            } else if (finalPath == "directory") {
                $(elements[2]).addClass("active");
                $(mobileEle[2]).addClass("active");
            } else if (finalPath == "ideas-and-inspiration") {
                $(elements[3]).addClass("active");
                $(mobileEle[3]).addClass("active");
            }
        },
        getAuthenticatedUser() {
            let _this = this;
            axios
                .get("/api/authcheck")
                .then(function (response) {
                    if (response.data == "False") {
                        _this.href = "#";
                        _this.loggedIn = false;
                    } else {
                        _this.loggedIn = true;
                        _this.href = `/${response.data}/welcome`;
                    }
                })
                .catch((error) => {
                    console.log(error.response);
                });
        },
        hideMobileToggleLinks() {
            let wid = screen.width;
            if (wid > 992) {
                this.toggleNavLinks = false;
            }
        },
    },
    mounted() {
        this.$nextTick(function () {
            this.getAuthenticatedUser();
            this.activeLink();
            this.hideMobileToggleLinks();
        });
        window.addEventListener("resize", this.hideMobileToggleLinks);
    },
};
</script>

<style scoped>
.landing-header-cont {
    display: flex;
    background-color: #461952;
    justify-content: space-between;
    padding: 10px 15px;
    padding-bottom: 0;
}
.landing-header-left {
    /* width: 10%; */
    display: flex;
    justify-content: space-between;
}
.landing-header-left > a > img {
    width: 80%;
    margin-bottom: 7px;
}
.landing-header-middle {
    text-align: left;
    margin-left: -500px;
}
.landing-header-right {
    display: flex;
    align-items: center;
    justify-content: flex-end;
}
.landing-header-middle-2 {
    display: none;
}
.landing-header-middle > a {
    text-decoration: none;
    display: inline-block;
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 20px;
    padding-left: 10px;
    padding-inline-start: 50px;
    padding-right: 19px;
    padding-top: 7px;
    margin-right: 10px;
    color: #ffffff;
    height: 100%;
}
.landing-header-middle > a:last-child {
    margin: 5px;
}
.landing-header-middle > a.active {
    color: #ffffff;
    font-weight: 900;
    border-bottom: 6px solid white;
}
.landing-header-right > div > a:nth-child(1),
.landing-header-right > div > a:nth-child(2) {
    text-decoration: none;
    background: #b52f6f;
    border-radius: 5px;
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 12px;
    line-height: 18px;
    text-align: center;
    color: #ffffff;
    padding: 7px 10px;
    border: none;
    outline: none;
    margin-right: 12px;
}
.landing-mobile-links {
    display: flex;
    overflow-y: auto;
    justify-content: space-around;
    padding: 1em;
}
.landing-mobile-links-single {
    background: #f7f7f7;
    border-radius: 8px;
    width: 118px;
    height: 147px;
    margin-right: 10px;
    text-align: center;
    padding: 25px 30px;
    text-decoration: none;
}
.landing-mobile-links-single.active {
    background-color: #b52f6f;
}
.landing-mobile-links-single.active > p {
    color: #ffffff;
}
.landing-mobile-links-single > div:nth-child(1) {
    background: #ffffff;
    border-radius: 100px;
    width: 56px;
    height: 56px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.landing-mobile-links-single > p {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 12px;
    line-height: 18px;
    align-items: center;
    margin-top: 10px;
    color: #898484;
}
.landing-mobile-links::-webkit-scrollbar {
    display: none;
}

#logout-btn {
    box-shadow: 0px 0px 0.817518px rgba(0, 0, 0, 0.25);
    border-radius: 6.54015px;
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 18px;
    color: #ffffff;
    padding: 8px 10px;
}
#dashboard-btn {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 6.54015px;
    padding: 9px 10px;
    font-style: normal;
    font-weight: 500;
    font-size: 14px;
    line-height: 18px;
}

/* Hide scrollbar for IE, Edge and Firefox */
.landing-mobile-links {
    -ms-overflow-style: none; /* IE and Edge */
    scrollbar-width: none; /* Firefox */
}
@media only screen and (max-width: 1080px) {
    .landing-header-right > div > a:nth-child(1),
    .landing-header-right > div > a:nth-child(2) {
        display: none;
    }
    .landing-header-right > div > a:nth-child(3),
    .landing-header-right > div > a:nth-child(4) {
        display: inline-block !important;
    }
}

@media only screen and (max-width: 992px) {
    .landing-header-right {
        justify-content: flex-end;
    }
    .landing-header-left > img:nth-child(1) {
        display: block !important;
    }
    .landing-header-middle {
        display: none !important;
    }
    .landing-header-left > a {
        display: none;
    }
    .landing-header-middle-2 {
        display: block;
    }
}
@media only screen and (max-width: 676px) {
    .landing-mobile-links {
        justify-content: unset;
    }
}
</style>
