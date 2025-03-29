<template>
    <div class="wed-host-section container mx-auto">
        <form
            v-if="edit == true || showForm == true"
            @submit.prevent="sendInvitation"
            class="wed-host-section-container"
        >
            <h1>Invitation Cover</h1>
            <div class="sel-side-cont">
                <div class="sel-side-inner">
                    <span @click="invi.side = 'bride'" :class="invi?.side == 'bride' ? 'sel-side-single active' : 'sel-side-single'">
                        <img src="/assets/bride-side.png" alt="">
                        Bride
                    </span>
                    <span @click="invi.side = 'groom'"  :class="invi?.side == 'groom' ? 'sel-side-single active' : 'sel-side-single'">
                        <img src="/assets/groom-side.png" alt="">
                        Groom
                    </span>
                </div>
                <span
                    v-if="errorsSubmit && errorsSubmit.side"
                    class="errMsg"
                    >{{ errorsSubmit.side[0] }}</span
                >
            </div>
            <div class="copule-info-container">
                <h1
                    @click="
                        show == 'brideFeilds'
                            ? (show = 'null')
                            : (show = 'brideFeilds')
                    "
                >
                    Bride's Info
                    <img
                        v-if="screenWidth <= 576 && show != 'brideFeilds'"
                        src="/assets/hosthome/pink-arr-up.svg"
                        alt=""
                    />
                    <img
                        v-if="screenWidth <= 576 && show == 'brideFeilds'"
                        src="/assets/hosthome/pink-arr-down.svg"
                        alt=""
                    />
                </h1>
                <div v-if="show == 'brideFeilds' || screenWidth >= 576">
                    <div class="form-group">
                        <label for="brideName">
                            Bride's name
                            <input
                                type="text"
                                name="brideName"
                                id="brideName"
                                placeholder="Enter bride name"
                                v-model="invi.brideName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.brideName"
                            class="errMsg"
                            >{{ errorsSubmit.brideName[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="brideNumber">
                            Bride's Mobile Number
                            <input
                                type="text"
                                name="brideNumber"
                                id="brideNumber"
                                placeholder="Enter bride number"
                                v-model="invi.brideMobile"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.brideMobile"
                            class="errMsg"
                            >{{ errorsSubmit.brideMobile[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="brideEmail">
                            Bride's Email
                            <input
                                type="text"
                                name="brideEmail"
                                id="brideEmail"
                                placeholder="Enter bride email"
                                v-model="invi.brideEmail"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.brideEmail"
                            class="errMsg"
                            >{{ errorsSubmit.brideEmail[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="brideMotherName">
                            Bride's Mother's name
                            <input
                                type="text"
                                name="brideMotherName"
                                id="brideMotherName"
                                placeholder="Enter bride mother name"
                                v-model="invi.brideMotherName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.brideMotherName"
                            class="errMsg"
                            >{{ errorsSubmit.brideMotherName[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="brideFatherName">
                            Bride's Father's name
                            <input
                                type="text"
                                name="brideFatherName"
                                id="brideFatherName"
                                placeholder="Enter bride father name"
                                v-model="invi.brideFatherName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.brideFatherName"
                            class="errMsg"
                            >{{ errorsSubmit.brideFatherName[0] }}</span
                        >
                    </div>
                </div>
            </div>
            <div class="copule-info-container">
                <h1
                    @click="
                        show == 'groomInfo'
                            ? (show = 'null')
                            : (show = 'groomInfo')
                    "
                >
                    Grooms's Info
                    <img
                        v-if="screenWidth <= 576 && show != 'groomInfo'"
                        src="/assets/hosthome/pink-arr-up.svg"
                        alt=""
                    />
                    <img
                        v-if="screenWidth <= 576 && show == 'groomInfo'"
                        src="/assets/hosthome/pink-arr-down.svg"
                        alt=""
                    />
                </h1>
                <div v-if="show == 'groomInfo' || screenWidth >= 576">
                    <div class="form-group">
                        <label for="groomName">
                            Groom's name
                            <input
                                type="text"
                                name="groomName"
                                id="groomName"
                                placeholder="Enter groom name"
                                v-model="invi.groomName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.groomName"
                            class="errMsg"
                            >{{ errorsSubmit.groomName[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="groomNumber">
                            Groom's Mobile Number
                            <input
                                type="text"
                                name="groomNumber"
                                id="groomNumber"
                                placeholder="Enter groom number"
                                v-model="invi.groomMobile"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.groomMobile"
                            class="errMsg"
                            >{{ errorsSubmit.groomMobile[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="groomEmail">
                            Groom's Email
                            <input
                                type="text"
                                name="groomEmail"
                                id="groomEmail"
                                placeholder="Enter groom email"
                                v-model="invi.groomEmail"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.groomEmail"
                            class="errMsg"
                            >{{ errorsSubmit.groomEmail[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="groomMotherName">
                            Groom's Mother's name
                            <input
                                type="text"
                                name="groomMotherName"
                                id="groomMotherName"
                                placeholder="Enter groom mother name"
                                v-model="invi.groomMotherName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.groomMotherName"
                            class="errMsg"
                            >{{ errorsSubmit.groomMotherName[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <label for="groomFatherName">
                            Groom's father'sname
                            <input
                                type="text"
                                name="groomFatherName"
                                id="groomFatherName"
                                placeholder="Enter groom father name"
                                v-model="invi.groomFatherName"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.groomFatherName"
                            class="errMsg"
                            >{{ errorsSubmit.groomFatherName[0] }}</span
                        >
                    </div>
                </div>
            </div>
            <div class="invi-details-container">
                <h1
                    @click="
                        show == 'weddingInfo'
                            ? (show = 'null')
                            : (show = 'weddingInfo')
                    "
                >
                    Wedding Info
                    <img
                        v-if="screenWidth <= 576 && show != 'weddingInfo'"
                        src="/assets/hosthome/pink-arr-up.svg"
                        alt=""
                    />
                    <img
                        v-if="screenWidth <= 576 && show == 'weddingInfo'"
                        src="/assets/hosthome/pink-arr-down.svg"
                        alt=""
                    />
                </h1>
                <div v-if="show == 'weddingInfo' || screenWidth >= 576">
                    <div class="form-group">
                        <label for="wedDate">
                            Wedding Date
                            <input
                                type="datetime-local"
                                name="wedDate"
                                id="wedDate"
                                v-model="invi.startDate"
                            />
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.startDate"
                            class="errMsg"
                            >{{ errorsSubmit.startDate[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <div class="multi-select" style="padding: 14px 20px">
                            <multiselect
                                v-model="invi.location_id"
                                placeholder="Select City"
                                :options="locations"
                                :show-labels="false"
                                :allow-empty="false"
                                track-by="name"
                                label="name"
                                ><span slot="noResult">No city exists.</span>
                            </multiselect>
                        </div>
                        <span
                            v-if="errorsSubmit && errorsSubmit.location_id"
                            class="errMsg"
                            >{{ errorsSubmit.location_id[0] }}</span
                        >
                    </div>
                    <div class="form-group">
                        <div class="multi-select" style="padding: 14px 20px">
                            <multiselect
                                v-model="invi.venue_id"
                                placeholder="Select Venue"
                                :options="venueList"
                                :show-labels="false"
                                :allow-empty="false"
                                track-by="name"
                                label="name"
                                ><span slot="noResult">No Venue Exists.</span>
                            </multiselect>
                        </div>
                        <div @click="showAddVenue= true">Add or Edit Your Venues!</div>
                        <span
                            v-if="errorsSubmit && errorsSubmit.venue_id"
                            class="errMsg"
                            >{{ errorsSubmit.venue_id[0] }}</span
                        >
                    </div>
                    <!-- <div class="form-group">
                        <label for="venue">
                            Venue
                            <select
                                v-model="invi.venue_id"
                                name="venue"
                                id="venue"
                            >
                                <option disabled value="default">
                                    Select Venue
                                </option>
                                <option
                                    v-for="item in venues"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                </option>
                            </select>
                        </label>
                        <span
                            v-if="errorsSubmit && errorsSubmit.venue_id"
                            class="errMsg"
                            >{{ errorsSubmit.venue_id[0] }}</span
                        >
                    </div> -->
                </div>
            </div>
            <div class="invi-details-submit-container">
                <div class="invi-pic-preview-cont">
                    <button type="button" @click="$refs.uploadInviPic.click()">
                        <img src="/assets/invitation/upload-pink.svg" alt="" />
                        Upload Image
                    </button>
                    <input
                        @change="uploadFile($event)"
                        ref="uploadInviPic"
                        type="file"
                    />
                    <img v-if="imageOnePreview" :src="imageOnePreview" alt="" />
                    <img
                        v-else-if="invitation?.imageOne"
                        :src="
                            '/assets/defaults/ceramonies/images/' +
                            invitation.imageOne
                        "
                        alt=""
                    />
                    <img
                        v-else
                        src="/assets/invitation/inviDefault.png"
                        alt=""
                    />
                    <span
                        v-if="errorsSubmit && errorsSubmit.imageOne"
                        class="errMsg"
                        >{{ errorsSubmit.imageOne[0] }}</span
                    >
                </div>
                <button type="submit" :disabled="disableSubmit">Submit</button>
            </div>
        </form>
        <div v-else class="wed-host-section-container">
            <div class="invi-card-result">
                <div class="invi-card-pic-cont">
                    <img
                        v-if="invi.imageOne"
                        :src="
                            '/assets/defaults/ceramonies/images/' +
                            invi.imageOne
                        "
                        alt=""
                    />
                    <img v-else src="/assets/invitation/Frame5652.png" alt="" />
                    <div>
                        <img
                            @click="edit = true"
                            src="/assets/miscellenous/edit.svg"
                            alt=""
                        />
                        <!-- <img src="/assets/trash.svg" alt="" /> -->
                    </div>
                </div>
                <div class="invi-card-content">
                    <h4>The Pleasure of your company is requested at the marriage of</h4>
                    <h1>{{ invi?.side == 'bride' ? invi.brideName : invi.groomName }}</h1>
                    <p>WEDS</p>
                    <h1>{{ invi?.side == 'groom' ? invi.brideName : invi.groomName }}</h1>
                    <h4>On {{ invi.startDate | moment("dddd, Do MMMM YYYY, LT") }} Onwards</h4>
                    <p style="font-size: 24px;"> <b>@</b></p>
                    <div v-for="item in invi.venues" :key="item.id">
                        
                        <h1> {{ item.name}}</h1>
                        <p>{{ item.address}}</p>
                    </div>
                    
                </div>
            </div>
        </div>
        <FlashMessage :message="message"></FlashMessage>
        <AddVenue v-if="showAddVenue == true" :hostvenues="hostVenueList" :showform="showAddVenue" @close="showAddVenue = false" @message="(n) => message = n" @venue="updateVenuelist"  @all="(n) => hostVenueList = n"></AddVenue>
    </div>
</template>

<script>
import FlashMessage from "../../FlashMessage.vue";
import Multiselect from "vue-multiselect";
import AddVenue from "../invitation/AddVenue.vue"

export default {
    props: ["loggedIn", "invitation", "venues", "locations", 'hostvenues'],
    components: {
        FlashMessage,
        Multiselect,
        AddVenue,
    },
    data() {
        return {
            invi: this.invitation ?? {side:''},
            //selectedCity: null,
            states: [],
            district: [],
            imageOne: null,
            imageOnePreview: null,
            disableSubmit: false,
            edit: false,
            message: null,
            errorsSubmit: null,
            showForm: true,
            screenWidth: window.screen.width,
            show: null,
            showAddVenue: false,
            venueList: this.venues,
            hostVenueList: this.hostvenues,
        };
    },
    methods: {
        updateVenuelist(n){
            if(n[1] == 'update'){
                for (var i = 0; i < this.venueList.length; i++) {
                    if (this.venueList[i].code == n[0].code) {
                        console.log('matched');
                        this.venueList[i].name = n[0].name;
                        break; // Exit the loop once the object is updated
                    }
                }
                return;
            }
            if(n[1] == 'add'){
                this.venueList.unshift(n[0]);
                return;
            }
        },
        uploadFile(e) {
            let _this = this;
            _this.imageOne = e.target.files[0];
            _this.imageOnePreview = URL.createObjectURL(_this.imageOne);
        },
        sendInvitation() {
            let _this = this;
            _this.disableSubmit = true;
            _this.errorsSubmit = null;
            let formData = new FormData();
            let code = _this.invi?.location_id?.code;
            let venueCode = _this.invi?.venue_id?.code;
            formData.append("type", "store");
            if (typeof _this.invi?.imageOne == "string") {
                delete _this.invi?.imageOne;
            }
            for (var key in _this.invi) {
                formData.append(key, _this.invi[key]);
            }
            if (_this.imageOne) {
                formData.append("imageOne", _this.imageOne);
            }
            formData.set("location_id", code);
            formData.set("venue_id", venueCode);
            let link = route("hostinvitations.store");
            let meth = "POST";
            if (_this.edit == true) {
                link = route("hostinvitations.update", _this.invi);
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
                    //console.log(response.data.slug);

                    if (_this.edit == false) {
                        let slug = response.data.data.slug;
                        window.location.href = `/host/savedate/${slug}`;
                        return;
                    }   
                    _this.invi = response.data["data"];

                    //console.log(typeof _this.invi?.location_id);
                    if(typeof _this.invi?.location_id == "number"){
                        _this.invi.location_id = _this.locations.find(function (item) {
                            return item.code == _this.invi.location_id;
                        });
                    }
                    _this.edit = false;
                    _this.showForm = false;
                    _this.disableSubmit = false;
                    _this.message = response.data["message"];
                    setTimeout(function () {
                        _this.message = null;
                    }, 3000);
                    _this.$root.$emit("updateinvi", response.data["data"]);
                })
                .catch((error) => {
                    _this.errorsSubmit = error.response.data?.errors;
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
        setWidth() {
            this.screenWidth = window.screen.width;
        },
    },
    mounted() {
        this.$nextTick(function () {
            let _this = this;
            window.addEventListener("resize", this.setWidth);
            if (this.invi?.location_id) {
                this.invi.location_id = _this.locations.find(function (item) {
                    return item.code == _this.invi.location_id;
                });
            }
            if (this.invi?.venue_id) {
                this.invi.venue_id = _this.venueList.find(function (item) {
                    return item.code == _this.invi.venue_id;
                });
            }
            // this.getStates();
            // if (this.invitation?.location_id && this.invitation?.state) {
            //     this.getDistricts(this.invitation.state, false);
            // }
            if (this.invitation) {
                this.showForm = false;
            }
        });
    },
};
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style scoped>
.wed-host-section-container > h1 {
    font-family: "Perpetua";
    font-style: normal;
    font-weight: 700;
    font-size: 30px;
    line-height: 34px;
    text-align: center;
    color: #9e3e5e;
}
.copule-info-container > h1,
.invi-details-container > h1 {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 22px;
    line-height: 33px;
    color: #333333;
}
.copule-info-container > div {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    grid-auto-rows: max-content;
    column-gap: 12px;
    row-gap: 4px;
    padding-top: 15px;
    padding-bottom: 36px;
}
.form-group {
    height: max-content;
}
.form-group > label,
.form-group > .multi-select {
    display: flex;
    flex-direction: column;
    background: #ffffff;
    border: 0.528708px solid #e9e9e9;
    border-radius: 5.28708px;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
    font-style: normal;
    height: 100%;
    padding: 10px 20px;
    font-weight: 500;
    font-size: 12px;
    line-height: 18px;
    color: #959595;
}
.form-group > label input,
.form-group > label select,
.form-group > label option {
    font-family: "Poppins", sans-serif;
    font-style: normal;
    font-weight: 400;
    font-size: 13px;
    line-height: 20px;
    color: #000000;
    outline: none;
    border: 0;
    margin: 5px 0;
    background-color: transparent !important;
}
.invi-details-container > div {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    grid-auto-rows: max-content;
    column-gap: 12px;
    row-gap: 4px;
    padding-top: 15px;
    padding-bottom: 36px;
}
.invi-details-submit-container {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: 15px;
}
.invi-pic-preview-cont > button {
    font-family: "Poppins";
    border: none;
    outline: none;
    font-style: normal;
    font-weight: 400;
    font-size: 15px;
    line-height: 8px;
    background: #fceef2;
    border: 0.643349px solid #c4456f;
    border-radius: 7.72019px;
    color: #c4456f;
    padding: 10px 22px;
}
.invi-pic-preview-cont > input {
    display: none;
}
.invi-pic-preview-cont {
    display: flex;
    align-items: flex-end;
}
.invi-pic-preview-cont > button > img {
    margin-right: 10px;
}
.invi-pic-preview-cont > img {
    width: 95px;
    height: 65px;
    margin-left: 55px;
}
.invi-details-submit-container > button {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 600;
    font-size: 13px;
    line-height: 20px;
    text-align: center;
    color: #ffffff;
    background: #c4456f;
    border-radius: 7.72px;
    padding: 11px 82px;
}
.invi-card-result {
    background: #ffffff;
    border: 1.91317px solid #ededf0;
    border-radius: 6.37724px;
    padding: 20px 17px;
    max-width: 425px;
    width: 100%;
    margin: auto;
}
.invi-card-pic-cont {
    position: relative;
    padding-top: 70%;
}
.invi-card-pic-cont > img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.invi-card-pic-cont > div {
    position: absolute;
    top: 11px;
    right: 9px;
    cursor: pointer;
}
.invi-card-pic-cont > div > img:nth-child(1) {
    margin-right: 10px;
}
.invi-card-content {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    padding: 30px 0;
}
.invi-card-content > h1 {
    font-family: "Futura Md BT";
    font-style: normal;
    font-weight: 400;
    font-size: 37.1421px;
    line-height: 45px;
    text-align: center;
    color: #b1415e;
    margin-bottom: 7px;
}
.invi-card-content > p {
    font-family: "Sedan";
    font-style: normal;
    font-weight: 400;
    font-size: 15.3997px;
    line-height: 21px;
    color: #000000;
    margin-bottom: 6px;
    text-transform: uppercase;
}
.invi-card-content > .text {
    font-family: "Chenla";
    font-style: normal;
    font-weight: 400;
    font-size: 14px;
    line-height: 26px;
    text-align: center;
    color: #000000;
}
.invi-card-content > div > h1 {
    font-family: "Futura Md BT";
    font-style: normal;
    font-weight: 400;
    font-size: 33.3363px;
    line-height: 40px;
    text-align: center;
    text-transform: capitalize;
    color: #b1415e;
}
.invi-card-content > div > p {
    font-family: "Chenla";
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 29px;
    text-align: center;
    color: #000000;
}
.invi-card-content > h4 {
    font-family: "Poppins";
    font-style: normal;
    font-weight: 500;
    font-size: 16px;
    line-height: 24px;
    text-align: center;
    color: #000000;
}
.sel-side-cont {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
    flex-direction: column;
}
.sel-side-inner {
    border-radius: 11px;
    background: #F9E9E9;
    padding: 4px;
}
.sel-side-inner > span:nth-child(1){
    margin-right: 5px;
}
.sel-side-single{
    display: inline-block;
    color: #000;
    font-family: Poppins;
    font-size: 11.351px;
    font-style: normal;
    font-weight: 500;
    line-height: normal;
    padding: 6px 11px;
    opacity: 0.5;
    cursor: pointer;
}
.sel-side-single.active{
    opacity: 1;
    background-color: white;
    border-radius: 4px;
}
.sel-side-single > img {
    margin-right: 7px;
}
@media screen and (max-width: 576px) {
    .copule-info-container > h1,
    .invi-details-container > h1 {
        text-align: center;
    }
    .copule-info-container,
    .invi-details-container {
        margin-bottom: 15px;
    }
    .invi-details-submit-container {
        margin-top: 0px;
    }
    .invi-details-submit-container {
        flex-wrap: wrap;
    }
    .invi-pic-preview-cont {
        width: 100%;
        justify-content: space-evenly;
    }
    .invi-details-submit-container > button {
        width: 100%;
        margin-top: 15px;
    }
    .invi-pic-preview-cont > img {
        margin-left: 10px;
    }
}
</style>
