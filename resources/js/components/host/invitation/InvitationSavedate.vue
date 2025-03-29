<template>
    <div class="wed-host-section container-md mx-auto">
        <div class="wed-host-section-container">
            <form
                v-if="edit == true || showForm == true"
                @submit.prevent="sendSaveDate"
                class="save-date-form"
            >
                <h1>Save The Date</h1>
                <h3>Upload the image for countdown</h3>
                <div
                    @dragover.prevent="drago($event)"
                    @dragleave.prevent="dragl($event)"
                    @drop.prevent="dragdrop($event)"
                    class="drag-drop-cont"
                >
                    <img src="/assets/savedate/savedateupload.png" alt="" />
                    <h5>{{ uploadMessage }}</h5>
                    <img
                        style="width: 100px; height: 100px"
                        v-if="uploadedImg"
                        :src="uploadedImg"
                        alt=""
                    />
                    <span>OR</span>
                    <button type="button" @click="$refs.savedateUpload.click()">
                        Browse files
                    </button>
                    <input
                        @change="uploadFile($event)"
                        type="file"
                        ref="savedateUpload"
                    />
                </div>
                <span
                    v-if="errorsSubmit && errorsSubmit.imageOne"
                    class="errMsg"
                    >{{ errorsSubmit.imageOne[0] }}</span
                >
                <div class="save-date-submit-cont">
                    <button :disabled="disableSubmit" type="submit">
                        Submit
                    </button>
                </div>
            </form>
            <div v-else>
                <h1 class="heading">Save The Date</h1>
                <div class="guest-banner-cont">
                    <img :src="'/storage' + dateSave.imageOne" alt="" />
                    <div class="overlay"></div>
                    <div class="guest-banner-content">
                        <div class="guest-banner-couple-name">
                            <span>{{ invitation.side == 'bride' ? invitation.brideName : invitation.groomName }}</span>
                            <span>weds</span>
                            <span>{{ invitation.side == 'groom' ? invitation.brideName : invitation.groomName }}</span>
                        </div>
                        <div>
                            <img
                                src="/assets/guestInvi/banner-invite.svg"
                                alt=""
                            />
                        </div>
                        <div class="guest-banner-venue-date">
                            <span>
                                <img
                                    src="/assets/guestInvi/banner-bird-left.svg"
                                    alt=""
                                />
                            </span>
                            <span
                                >{{ invitation.startDate | moment("dddd, Do") }},
                                {{ invitation.startDate | moment("MMMM YYYY LT") }} --
                                {{ invitation.venues[0].name }},
                                {{ invitation.venues[0].location.name }}</span
                            >
                            <span>
                                <img
                                    src="/assets/guestInvi/banner-bird-right.svg"
                                    alt=""
                                />
                            </span>
                        </div>
                        <div class="guest-banner-timer">
                            <div class="guest-banner-timer-single">
                                <span></span>
                                <span>days</span>
                            </div>
                            <div class="guest-banner-timer-single">
                                <span></span>
                                <span>hours</span>
                            </div>
                            <div class="guest-banner-timer-single">
                                <span></span>
                                <span>minutes</span>
                            </div>
                            <div class="guest-banner-timer-single">
                                <span></span>
                                <span>seconds</span>
                            </div>
                        </div>
                        <div class="guest-banner-slogan">
                            <div>Happy to celebrate this special day with you!</div>
                            <div>
                                With pride and joy, we invite you to share a
                                special day in our lives as we…
                            </div>
                        </div>
                    </div>
                    <div>
                        <img
                            @click="
                                edit = true;
                                uploadMessage = 'Change Old Image';
                            "
                            src="/assets/miscellenous/edit.svg"
                            alt=""
                        />
                        <!-- <img src="/assets/trash.svg" alt="" /> -->
                    </div>
                </div>
            </div>
        </div>
        <FlashMessage :message="message"></FlashMessage>
    </div>
</template>

<script>
import FlashMessage from "../../FlashMessage.vue";

export default {
    props: ["loggedIn", "invitation", "savedate"],
    components: {
        FlashMessage,
    },
    data() {
        return {
            dateSave: this.savedate,
            uploadMessage: "Drag & Drop your file here",
            imageOne: null,
            disableSubmit: false,
            edit: false,
            message: null,
            errorsSubmit: null,
            showForm: true,
            uploadedImg: null,
        };
    },
    methods: {
        sendSaveDate() {
            let _this = this;
            _this.disableSubmit = true;
            _this.errorsSubmit = null;
            let formData = new FormData();
            formData.append("type", "store");
            if (typeof _this.dateSave?.imageOne == "string") {
                delete _this.dateSave?.imageOne;
            }
            if (_this.imageOne) {
                formData.append("imageOne", _this.imageOne);
            }
            let link = route("hostsavedate.store", _this.invitation);
            let meth = "POST";
            if (_this.edit == true) {
                link = route("hostsavedate.update", [
                    _this.invitation,
                    _this.dateSave,
                ]);
                formData.append("_method", "PATCH");
                formData.append("type", "update");
            }
            axios({
                method: meth,
                url: link,
                data: formData,
                headers: { "content-type": "multipart/form-data" },
            })
                .then((response) => {
                        if (_this.edit == false) {
                            window.location.href = `/host/ceramony/${_this.invitation?.slug}`;
                            return;
                        }
                    _this.edit = false;
                    _this.showForm = false;
                    _this.disableSubmit = false;
                    _this.message = response.data["message"];
                    _this.dateSave = response.data["data"];
                    _this.uploadMessage = "Drag & Drop your file here";
                    _this.imageOne = null;
                    _this.countDown();
                    setTimeout(function () {
                        _this.message = null;
                    }, 3000);
                })
                .catch((error) => {
                    _this.errorsSubmit = error.response.data?.errors;
                    console.log(error.response.data.errors);
                    // _this.message = response.data["message"];
                    _this.disableSubmit = false;
                    if (error.response.data["message"]) {
                        _this.message = error.response.data["message"];
                        setTimeout(function () {
                            _this.message = null;
                        }, 3000);
                    }
                });
        },
        drago(e) {
            this.uploadMessage = "Drop your File";
        },
        dragl(e) {
            if (this.imageOne) {
                this.uploadMessage = this.imageOne.name;
                this.uploadedImg = URL.createObjectURL(this.imageOne);
            } else {
                this.uploadMessage = "Drag & Drop your file here";
                this.uploadedImg = null;
            }
        },
        dragdrop(e) {
            this.imageOne = e.dataTransfer.files[0];
            this.uploadMessage = e.dataTransfer.files[0].name;
            this.uploadedImg = URL.createObjectURL(this.imageOne);
        },
        uploadFile(e) {
            this.imageOne = e.target.files[0];
            this.uploadMessage = e.target.files[0].name;
            this.uploadedImg = URL.createObjectURL(this.imageOne);
        },
        async countDown() {
            await this.$nextTick();
            const fixedDate = this.invitation.startDate;
            const deadlineTimer = document.querySelectorAll(
                ".guest-banner-timer-single > span:nth-child(1)"
            );

            const futureDate = new Date(fixedDate);

            const futureTime = futureDate.getTime();

            function getRemainingTime() {
                let today = new Date().getTime();

                let totalRemainingMS = futureTime - today;
                if (totalRemainingMS < 0) {
                    clearInterval(countdown);
                    return;
                }

                //values in ms
                const Oneday = 24 * 60 * 60 * 1000;
                const Onehour = 60 * 60 * 1000;
                const Oneminutes = 60 * 1000;

                //remaining time calulation
                let Day = Math.floor(totalRemainingMS / Oneday);
                let Hour = Math.floor((totalRemainingMS % Oneday) / Onehour);
                let Minutes = Math.floor(
                    (totalRemainingMS % Onehour) / Oneminutes
                );
                let Seconds = Math.floor(
                    (totalRemainingMS % Oneminutes) / 1000
                );

                const value = [Day, Hour, Minutes, Seconds];

                function format(item) {
                    if (item < 10) {
                        return (item = `0${item}`);
                    } else {
                        return item;
                    }
                }
                deadlineTimer.forEach(function (item, index) {
                    item.innerHTML = format(value[index]);
                });
            }
            let countdown = setInterval(getRemainingTime, 1000);
            getRemainingTime();
        },
    },
    mounted() {
        this.$nextTick(() => {
            if (this.dateSave) {
                this.showForm = false;
            }
            if (this.invitation && this.dateSave) {
                this.countDown();
            }
        });
    },
};
</script>

<style scoped>
.save-date-form > h1,
.heading {
    font-family: "Perpetua";
    font-style: normal;
    font-weight: 700;
    font-size: 30px;
    line-height: 34px;
    text-align: center;
    width: 100%;
    color: #9e3e5e;
}
.save-date-form > h3 {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 300;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    width: 100%;
    color: #000000;
}
.drag-drop-cont {
    max-width: 493px;
    width: 100%;
    background: linear-gradient(180deg, #fafcff 0%, #f1f6ff 100%);
    border: 2px dashed #c8c3c3;
    padding: 28px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    margin: auto;
}
.drag-drop-cont > img {
    width: 41px;
    height: 34px;
    margin-bottom: 15px;
}
.drag-drop-cont > h5 {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 12.1302px;
    line-height: 18px;
    color: #8b8b8b;
}
.drag-drop-cont > span {
    font-family: "Montserrat";
    font-style: normal;
    font-weight: 500;
    font-size: 9.79749px;
    line-height: 12px;
    color: #c8c3c3;
}
.drag-drop-cont > button {
    background: #dcdcdb;
    border-radius: 4.47811px;
    border: none;
    outline: none;
    padding: 10px 19px;
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 10.2347px;
    line-height: 15px;
    text-align: center;
    color: #747474;
    margin-top: 10px;
}
.drag-drop-cont > input {
    display: none;
}

.save-date-submit-cont {
    width: 100%;
    text-align: center;
    margin: 48px 0;
}
.save-date-submit-cont > button {
    background: #c4456f;
    border-radius: 7.72px;
    padding: 11px 82px;
    border: none;
    outline: none;
    font-family: "Poppins";
    font-style: normal;
    font-weight: 600;
    font-size: 13px;
    line-height: 20px;
    text-align: center;
    color: #ffffff;
}
.save-date-form > .errMsg {
    display: block;
    text-align: center;
    margin-top: 12px;
}
/* Banner css start */
.guest-banner-cont {
    padding-top: 55%;
    position: relative;
    width: 100%;
    height: 100%;
    top: 0;
}
.guest-banner-cont > img:nth-child(1) {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    object-fit: cover;
}
.guest-banner-cont > .overlay {
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    z-index: 999;
}
.guest-banner-cont > div:nth-child(4) {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 99999;
    cursor: pointer;
}
.guest-banner-content {
    margin: auto;
    position: absolute;
    top: 3%;
    text-align: center;
    display: flex;
    flex-direction: column;
    width: 100%;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
/* .guest-banner-content {
    margin-bottom: 3em;
} */
.guest-banner-accept > button {
    font-family: "Segoe UI";
    font-style: normal;
    font-weight: 700;
    font-size: 13.052px;
    line-height: 17px;
    text-transform: uppercase;
    padding: 13px 38px;
}
.guest-banner-accept > button:nth-child(1) {
    outline: none;
    background: rgba(196, 69, 111, 0.5);
    border: 1.12998px solid #c4456f;
    border-radius: 6.81176px;
    color: #ffffff;
    margin-right: 15px;
}
.guest-banner-accept > button:nth-child(2) {
    outline: none;
    background: rgba(72, 72, 72, 0.2);
    border: 1.12998px solid #696969;
    border-radius: 6.81176px;
    color: #ffffff;
}
.guest-banner-couple-name {
    margin-top: 2em;
}
.guest-banner-couple-name > span {
    font-family: "STSong";
    font-style: normal;
    font-weight: 400;
    font-size: 29.2084px;
    line-height: 38px;
    text-transform: uppercase;
    color: #ffffff;
}
.guest-banner-couple-name > span:nth-child(2) {
    font-family: "Stalemate";
    font-style: normal;
    font-weight: 400;
    font-size: 53.1063px;
    line-height: 78px;
    color: #ffffff;
    text-transform: none;
    margin: 0 20px;
}
.guest-banner-venue-date {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    text-transform: capitalize;
    color: #ffffff;
    position: relative;
    display: flex;
    flex-wrap: nowrap;
}
.guest-banner-venue-date > span {
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
}
.guest-banner-venue-date > span:nth-child(2) {
    margin: 0 7px;
}

.guest-banner-venue-date > span:nth-child(1)::after {
    content: "";
    position: relative;
    width: 50px;
    height: 2px;
    top: -1px;
    background: #ffffff;
    display: inline-block;
    right: 0;
    z-index: 99999;
}
.guest-banner-venue-date > span:nth-child(3)::before {
    content: "";
    position: relative;
    width: 50px;
    height: 2px;
    top: -1px;
    background: #ffffff;
    display: inline-block;
    right: 0;
    z-index: 99999;
}
.guest-banner-timer {
    display: flex;
    margin: 42px auto;
}
.guest-banner-timer-single {
    background: rgba(255, 255, 255, 0.3);
    box-shadow: 0px 0px 4px 1px rgba(0, 0, 0, 0.25);
    padding: 12px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    margin-right: 12px;
    width: 76px;
    height: 76px;
}
.guest-banner-timer:last-child {
    margin-right: 0;
}
.guest-banner-timer-single > span:nth-child(1) {
    font-family: "Perpetua";
    font-style: normal;
    font-weight: 400;
    font-size: 44.083px;
    line-height: 51px;
    text-align: center;
    display: block;
    color: #ffffff;
}
.guest-banner-timer-single > span:nth-child(2) {
    font-family: "Segoe UI";
    font-style: normal;
    font-weight: 400;
    font-size: 7.62142px;
    line-height: 10px;
    display: block;
    text-align: center;
    color: #ffffff;
}
.guest-banner-slogan > div:nth-child(1) {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 24.7422px;
    line-height: 37px;
    text-align: center;
    text-transform: capitalize;
    color: #ffffff;
}
.guest-banner-slogan > div:nth-child(2) {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 400;
    font-size: 14.8453px;
    line-height: 22px;
    text-align: center;
    text-transform: lowercase;

    color: #dfdfdf;
}
@media screen and (max-width: 1600px) {
    .guest-banner-cont {
        padding-top: 50%;
    }
}
@media screen and (max-width: 1300px) {
    .guest-banner-cont {
        padding-top: 60%;
    }
}
@media screen and (max-width: 1200px) {
    .guest-banner-cont {
        padding-top: 70%;
    }
}
@media screen and (max-width: 991px) {
    .guest-banner-cont {
        padding-top: 80%;
    }
    .guest-banner-timer {
        margin: 22px auto;
    }
    .guest-banner-timer-single {
        width: 76px;
        height: 76px;
    }
    /* .guest-banner-timer-single > span:nth-child(1) {
        font-size: 60px;
        line-height: 60px;
    } */
    .guest-banner-content {
        top: 3%;
    }
    .wed-host-section-container {
        padding: 4em 0 !important;
        padding-bottom: 6em !important;
    }
}
@media screen and (max-width: 768px) {
    .guest-banner-cont {
        padding-top: 100%;
    }
    .guest-banner-couple-name {
        margin-top: 1px;
    }
    .guest-banner-cont {
        padding-top: 83%;
    }
}
@media screen and (max-width: 576px) {
    .guest-banner-couple-name > span {
        font-weight: 400;
        font-size: 18.2232px;
        line-height: 24px;
    }
    .guest-banner-couple-name > span:nth-child(2) {
        font-weight: 400;
        font-size: 33.1331px;
        line-height: 49px;
    }
    .guest-banner-venue-date {
        font-weight: 500;
        font-size: 10px;
        line-height: 15px;
    }
    .guest-banner-timer-single > span:nth-child(1) {
        font-weight: 400;
        font-size: 35.2648px;
        line-height: 40px;
    }
    .guest-banner-timer-single {
        width: 66px;
        height: 65px;
        padding: 0;
    }
    .guest-banner-slogan > div:nth-child(1) {
        font-weight: 400;
        font-size: 10.6195px;
        line-height: 16px;
    }
    .guest-banner-slogan > div:nth-child(2) {
        font-weight: 400;
        font-size: 6.37168px;
        line-height: 10px;
    }
    .guest-banner-content {
        top: 8%;
    }
    .wed-host-section-container {
        padding: 4em 0 !important;
    }
}
</style>
