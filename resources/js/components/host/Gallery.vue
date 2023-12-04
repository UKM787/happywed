<template>
    <div>
        <div class="gallery-all-cont wed-host-gallery container-md">
            <div>
                <div
                    @click="
                        activeGallery = 'Pictures';
                        clickedAlbum = [];
                    "
                    :class="{
                        'wed-host-gallery-active': activeGallery == 'Pictures',
                    }"
                >
                    Pictures
                </div>
                <div
                    @click="
                        activeGallery = 'Albums';
                        clickedAlbum = [];
                    "
                    :class="{
                        'wed-host-gallery-active': activeGallery == 'Albums',
                    }"
                >
                    Albums
                </div>
                <div
                    @click="
                        activeGallery = 'Videos';
                        clickedAlbum = [];
                    "
                    :class="{
                        'wed-host-gallery-active': activeGallery == 'Videos',
                    }"
                >
                    Videos
                </div>
            </div>
            <div class="wed-host-gallery-items">
                <div v-if="activeGallery == 'Pictures'">
                    <form
                        @submit.prevent="sendPictures($event)"
                        class="wed-image-form gallery_upload_form"
                    >
                        <div class="p-3">
                            <div class="row p-2">
                                <label for="album" class="form-label">
                                    Album Name</label
                                >
                                <input
                                    type="text"
                                    name="album"
                                    class="form-control"
                                    v-model="albumName"
                                    required
                                />
                            </div>
                            <div class="row mb-2 p-2">
                                <label for="image" class="form-label"
                                    >Add Images</label
                                >
                                <input
                                    type="file"
                                    name="galleryImage[]"
                                    class="form-control form-control-sm"
                                    id=""
                                    multiple
                                    @change="uploadImages($event)"
                                />
                                <span
                                    v-if="
                                        errorsSubmit &&
                                        errorsSubmit.galleryImage
                                    "
                                    class="errMsg"
                                    >{{ errorsSubmit.galleryImage[0] }}</span
                                >
                                <div>{{ uploadMultiMessage }}</div>
                            </div>
                            <div class="row p-3">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary"
                                    :disabled="disablePictures"
                                >
                                    Create Album
                                </button>
                            </div>
                        </div>
                    </form>
                    <div
                        v-for="(item, index) in allGalleries"
                        :key="index"
                        class="img-cont"
                    >
                        <img
                            :src="
                                '/files/' +
                                invitations.id +
                                '/' +
                                item.imageName
                            "
                            alt=""
                        />
                    </div>
                </div>
                <div
                    id="all-albums"
                    v-if="activeGallery == 'Albums' && clickedAlbum.length == 0"
                >
                    <div
                        v-for="(item, index) in allAlbums"
                        :key="index"
                        @click="clickedAlbum = item.images"
                        class="album-cont"
                    >
                        <span>
                            {{ item.images.length }}
                            <img src="/assets/guestInvi/bi_image-fill.svg" />
                        </span>
                        <img src="/assets/guestInvi/Frame-5602-1.png" alt="" />
                        <span> {{ item.name }} </span>
                    </div>
                </div>
                <div v-else class="album-pics">
                    <div
                        v-for="single in clickedAlbum"
                        :key="single.imageName"
                        class="img-cont"
                    >
                        <img
                            :src="
                                '/files/' +
                                invitations.id +
                                '/' +
                                single.imageName
                            "
                            alt=""
                        />
                    </div>
                </div>
                <div v-if="activeGallery == 'Videos'">
                    <form
                        class="wed-image-form gallery_upload_form"
                        @submit.prevent="sendPictures($event)"
                    >
                        <div class="p-3">
                            <div class="row mb-2 p-2">
                                <label for="image" class="form-label"
                                    >Add Video</label
                                >
                                <input
                                    type="file"
                                    name="galleryImage[]"
                                    class="form-control form-control-sm"
                                    id=""
                                    multiple
                                    @change="uploadImages($event)"
                                />
                                <span
                                    v-if="
                                        errorsSubmit &&
                                        errorsSubmit.galleryVideo
                                    "
                                    class="errMsg"
                                    >{{ errorsSubmit.galleryVideo[0] }}</span
                                >
                                <div>{{ uploadMultiMessage }}</div>
                            </div>
                            <div class="row p-3">
                                <button
                                    :disabled="disablePictures"
                                    class="btn btn-sm btn-primary"
                                >
                                    Upload Video
                                </button>
                            </div>
                        </div>
                    </form>
                    <div
                        v-for="(item, index) in allVideos"
                        :key="index"
                        class="img-cont"
                    >
                        <video controls>
                            <source
                                :src="
                                    '/videos/' +
                                    invitations.id +
                                    '/' +
                                    item.name
                                "
                            />
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
        <flashMessage :message="message"></flashMessage>
    </div>
</template>

<script>
import flashMessage from "../FlashMessage.vue";

export default {
    components: {
        flashMessage,
    },
    props: ["albums", "galleries", "videos", "host", "invitations"],
    data() {
        return {
            activeGallery: "Pictures",
            clickedAlbum: [],
            message: null,
            uploadMultiImage: [],
            uploadMultiMessage: null,
            albumName: null,
            allAlbums: this.albums,
            allGalleries: this.galleries,
            allVideos: this.videos,
            disablePictures: false,
            errorsSubmit: null,
        };
    },
    methods: {
        uploadImages(e) {
            this.uploadMultiImage = e.target.files;
            this.uploadMultiMessage =
                this.uploadMultiImage.length + " Files Upoladed!!";
        },
        sendPictures(e) {
            let _this = this;
            _this.disablePictures = true;
            _this.errorsSubmit = null;
            let formData = new FormData();
            let link = null;
            if (_this.activeGallery == "Pictures") {
                formData.append("album", _this.albumName);
                let images = null;
                if (_this.uploadMultiImage.length > 0) {
                    images = [..._this.uploadMultiImage];
                    images.forEach(function (item, index) {
                        formData.append("galleryImage[" + index + "]", item);
                    });
                }
                link = route("addAlbum", _this.host);
            }
            if (_this.activeGallery == "Videos") {
                let images = null;
                if (_this.uploadMultiImage.length > 0) {
                    images = [..._this.uploadMultiImage];
                    images.forEach(function (item, index) {
                        formData.append("galleryVideo[" + index + "]", item);
                    });
                }
                link = route("hostvideoUpload", _this.host);
            }

            let meth = "POST";

            axios({
                method: meth,
                url: link,
                data: formData,
                headers: { "content-type": "multipart/form-data" },
            })
                .then((response) => {
                    _this.allAlbums = response.data[0];
                    _this.allGalleries = response.data[1];
                    _this.allVideos = response.data[2];
                    _this.message = "Uploaded!!!";
                    _this.uploadMultiMessage = null;
                    _this.uploadMultiImage = [];
                    _this.disablePictures = false;
                    setTimeout(function () {
                        _this.message = null;
                    }, 3000);
                })
                .catch((error) => {
                    _this.disablePictures = false;
                    if (_this.activeGallery == "Pictures") {
                        _this.errorsSubmit = {
                            galleryImage: Object.values(
                                error.response.data?.errors
                            )[0],
                        };
                    }
                    if (_this.activeGallery == "Videos") {
                        _this.errorsSubmit = {
                            galleryVideo: Object.values(
                                error.response.data?.errors
                            )[0],
                        };
                    }
                });
        },
    },
};
</script>

<style scoped>
/* Gallery all css start */
.wed-host-gallery {
    background-color: white;
    margin-top: 2em;
    padding: 10px 0;
}

.wed-host-gallery > div:nth-child(1) {
    display: flex;
    justify-content: center;
}

.wed-host-gallery-active {
    font-weight: bold !important;
    color: #7f004b !important;
    border-bottom: 4px solid #7f004b !important;
}

.wed-host-gallery > div:nth-child(1) > div {
    font-family: Roboto;
    font-style: normal;
    font-weight: normal;
    font-size: 17.8211px;
    line-height: 21px;
    color: #968585;
    flex: 1;
    text-align: center;
    padding: 2em 0;
    border-right: 0.891053px solid #cbc7c7;
    border-bottom: 0.891053px solid #cbc7c7;
    cursor: pointer;
}
.wed-host-gallery > div:nth-child(1) > div:last-child {
    border-right: none;
}
.wed-host-gallery-items {
    padding-bottom: 1em;
}
.wed-host-gallery-items > div {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    grid-auto-rows: max-content;
    padding: 1em;
    grid-column-gap: 1em;
    grid-row-gap: 1.5em;
}
.img-cont,
.album-cont {
    position: relative;
    padding-top: 100%;
    border-radius: 20px;
}
.img-cont > img,
.img-cont > video,
.album-cont > img {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    z-index: 99;
}
.album-cont > span:nth-child(1) {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 999;
    font-family: "Roboto";
    font-style: normal;
    font-weight: 400;
    font-size: 16px;
    line-height: 19px;
    color: #ffffff;
}
.album-cont > span:nth-child(3) {
    position: absolute;
    bottom: 15px;
    left: 15px;
    z-index: 999;
    font-family: "Roboto";
    font-style: normal;
    font-weight: 500;
    font-size: 15px;
    line-height: 18px;
    color: #ffffff;
}
.album-pics {
    /* display: none;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    grid-auto-rows: max-content;
    padding: 1em;
    grid-column-gap: 1em;
    grid-row-gap: 1.5em; */
}
/* .album-pics.active {
    display: grid !important;
}
.album-cont.active {
    display: none !important;
} */

/* Gallery all css end */
.wed-image-form {
    grid-column-start: 1;
    grid-column-end: 3;
}

.gallery_upload_form {
    background: rgba(226, 226, 226, 0.6);
    backdrop-filter: blur(4px);
    border-radius: 17.8211px;
    height: max-content;
}

.gallery_album_form {
    background: rgba(226, 226, 226, 0.6);
    backdrop-filter: blur(4px);
    border-radius: 17.8211px;
}

/* .gallery_upload_form>input {
            display:none;
        } */

.gallery_upload_form1 > label {
    display: flex;
    justify-content: center;
    width: 100%;
    height: 100%;
    cursor: pointer;
    flex-direction: column;
}

.gallery_upload_form1 > label > span {
    align-self: center;
}

.gallery_upload_form > label {
    display: flex;
    justify-content: center;
    width: 100%;
    height: 100%;
    cursor: pointer;
    flex-direction: column;
}

.gallery_upload_form > label > span {
    align-self: center;
}
@media screen and (max-width: 769px) {
    .wed-host-gallery {
        padding: 14px 0 !important;
    }
}
@media screen and (max-width: 576px) {
    .wed-host-gallery-items > div {
        display: grid;
        grid-template-columns: repeat(2, 1fr) !important;
        grid-auto-rows: max-content;
        padding: 1em;
        grid-column-gap: 1em;
        grid-row-gap: 1.5em;
    }
}
</style>
