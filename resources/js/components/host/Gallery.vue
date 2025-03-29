<template>
    <div>
        <div class="gallery-all-cont wed-host-gallery container-md">
            <div>
                <!--<div
                    @click="
                        activeGallery = 'Pictures';
                        clickedAlbum = [];
                    "
                    :class="{
                        'wed-host-gallery-active': activeGallery == 'Pictures',
                    }"
                >
                    Pictures
                </div>-->
                <div
                    @click="
                        activeGallery = 'Memories';
                        clickedAlbum = [];
                    "
                    :class="{
                        'wed-host-gallery-active': activeGallery == 'Memories',
                    }"
                >
                    Picture
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
                
            </div>
            <div class="wed-host-gallery-items">
                <div v-if="activeGallery == 'Pictures'">
                    <form
                        @submit.prevent="sendPictures($event)"
                        class="wed-image-form gallery_upload_form"
                    >
                        <div class="p-3">
                            <div class="row mb-2 p-2">
                                <label for="image" class="form-label">Add Pictures</label>
                                <input
                                    type="file"
                                    name="galleryPicture[]"
                                    class="form-control form-control-sm"
                                    multiple
                                    @change="uploadImages($event)"
                                    accept="image/*"
                                />
                                <span
                                    v-if="errorsSubmit && errorsSubmit.galleryPicture"
                                    class="errMsg"
                                >{{ errorsSubmit.galleryPicture[0] }}</span>
                                <div>{{ uploadMultiMessage }}</div>
                            </div>
                            <div class="row p-3">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary"
                                    :disabled="disablePictures"
                                >
                                    Upload Pictures
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="pictures-grid">
                        <div
                            v-for="(picture, index) in allPictures"
                            :key="index"
                            class="img-cont"
                        >
                            <div class="delete-btn">
                                <button @click="deletePicture(picture.id)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <img
                                :src="'/files/' + invitations.id + '/' + picture.imageName"
                                alt=""
                            />
                        </div>
                    </div>
                </div>
                <div v-if="activeGallery == 'Albums'">
                    <form
                        @submit.prevent="sendPictures($event)"
                        class="wed-image-form gallery_upload_form"
                    >
                        <div class="p-3">
                            <div class="row p-2">
                                <label for="album" class="form-label">Album Name</label>
                                <input
                                    type="text"
                                    name="album"
                                    class="form-control"
                                    v-model="albumName"
                                    required
                                />
                            </div>
                            <div class="row mb-2 p-2">
                                <label for="image" class="form-label">Add Images</label>
                                <input
                                    type="file"
                                    name="galleryImage[]"
                                    class="form-control form-control-sm"
                                    multiple
                                    @change="uploadImages($event)"
                                    accept="image/*"
                                />
                                <span v-if="errorsSubmit && errorsSubmit.galleryImage" class="errMsg">
                                    {{ errorsSubmit.galleryImage[0] }}
                                </span>
                            </div>
                            <div class="row mb-2 p-2">
                                <label for="video" class="form-label">Add Videos</label>
                                <input
                                    type="file"
                                    name="galleryVideo[]"
                                    class="form-control form-control-sm"
                                    multiple
                                    @change="uploadImages($event)"
                                    accept="video/*"
                                />
                                <span v-if="errorsSubmit && errorsSubmit.galleryVideo" class="errMsg">
                                    {{ errorsSubmit.galleryVideo[0] }}
                                </span>
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
                </div>
                <div id="all-albums" v-if="activeGallery == 'Albums' && clickedAlbum.length == 0">
                    <div
                        v-for="(item, index) in allAlbums"
                        :key="index"
                        @click="clickedAlbum = item.images"
                        class="album-cont"
                    >
                        <div class="delete-btn">
                            <button @click.stop="deleteAlbum(item.id)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <span>
                            {{ item.images.length }}
                            <img src="/assets/guestInvi/bi_image-fill.svg" />
                        </span>
                        <img v-if="item.images.length && item.images[0].type === 'image'" 
                             :src="'/files/' + invitations.id + '/' + item.images[0].imageName" 
                             alt="Album Cover" />
                        <video v-if="item.images.length && item.images[0].type === 'video'"
                               :src="'/videos/' + invitations.id + '/' + item.images[0].imageName"
                               class="album-cover-video"></video>
                        <span>{{ item.name }}</span>
                    </div>
                </div>
                <div v-if="activeGallery == 'Albums' && clickedAlbum.length">
                    <div class="album-header mb-3">
                        <button @click="clickedAlbum = []" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Albums
                        </button>
                    </div>
                    <div class="album-grid">
                        <div v-for="item in clickedAlbum" :key="item.id" class="img-cont">
                            <div class="delete-btn">
                                <button @click="deleteAlbumItem(item.id)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <img v-if="item.type === 'image'"
                                 :src="'/files/' + invitations.id + '/' + item.imageName"
                                 alt="Album Image" />
                            <video v-if="item.type === 'video'"
                                   :src="'/videos/' + invitations.id + '/' + item.imageName"
                                   controls
                                   class="album-video"></video>
                        </div>
                    </div>
                </div>
                <div v-if="activeGallery == 'Videos'">
                    <form
                        class="wed-image-form gallery_upload_form"
                        @submit.prevent="sendPictures($event)"
                    >
                        <div class="p-3">
                            <div class="row mb-2 p-2">
                                <label for="video" class="form-label">Add Videos</label>
                                <input
                                    type="file"
                                    name="galleryVideo[]"
                                    class="form-control form-control-sm"
                                    multiple
                                    @change="uploadImages($event)"
                                />
                                <span
                                    v-if="errorsSubmit && errorsSubmit.galleryVideo"
                                    class="errMsg"
                                >{{ errorsSubmit.galleryVideo[0] }}</span>
                                <div>{{ uploadMultiMessage }}</div>
                            </div>
                            <div class="row p-3">
                                <button
                                    type="submit"
                                    :disabled="disablePictures"
                                    class="btn btn-sm btn-primary"
                                >
                                    Upload Videos
                                </button>
                            </div>
                        </div>
                    </form>
                    <div v-for="(video, index) in allVideos" :key="index" class="video-cont">
                        <div class="delete-btn">
                            <button @click="deleteVideo(video.id)" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <video 
                            :src="'/videos/' + invitations.id + '/' + video.name"
                            controls
                            class="video-player"
                        ></video>
                        <div class="video-name">{{ video.name }}</div>
                    </div>
                </div>
                <div v-if="activeGallery == 'Memories'">
                    <form
                        @submit.prevent="sendPictures($event)"
                        class="wed-image-form gallery_upload_form"
                    >
                        <div class="p-3">
                            <div class="row mb-2 p-2">
                                <label for="memory" class="form-label">Add Memories</label>
                                <input
                                    type="file"
                                    name="galleryMemory[]"
                                    class="form-control form-control-sm"
                                    multiple
                                    @change="uploadImages($event)"
                                    accept="image/*"
                                />
                                <span
                                    v-if="errorsSubmit && errorsSubmit.galleryMemory"
                                    class="errMsg"
                                >{{ errorsSubmit.galleryMemory[0] }}</span>
                                <div>{{ uploadMultiMessage }}</div>
                            </div>
                            <div class="row p-3">
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-primary"
                                    :disabled="disablePictures"
                                >
                                    Upload Memories
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="pictures-grid">
                        <div
                            v-for="(memory, index) in allMemories"
                            :key="index"
                            class="img-cont"
                        >
                            <div class="delete-btn">
                                <button @click="deleteMemory(memory.id)" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <img
                                :src="'/uploads/memories/' + memory.imageName"
                                alt="Memory"
                            />
                        </div>
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
            allPictures: this.galleries.filter(g => !g.is_picture || g.picture_type === 'gallery').concat(
                this.albums.flatMap(album => album.images)
            ),
            allMemories: [],
            clickedAlbum: [],
            message: null,
            uploadMultiImage: [],
            uploadMultiMessage: null,
            albumName: null,
            allAlbums: this.albums,
            allGalleries: this.galleries,
            allVideos: this.videos,
            disablePictures: false,
            errorsSubmit: {},
            galleryMemory: [],
        };
    },
    methods: {
        uploadImages(e) {
            if (this.activeGallery === "Memories") {
                this.galleryMemory = e.target.files;
                this.uploadMultiMessage = this.galleryMemory.length + " Files Selected!";
            } else {
                this.uploadMultiImage = e.target.files;
                this.uploadMultiMessage = this.uploadMultiImage.length + " Files Selected!";
            }
        },
        sendPictures(e) {
            let _this = this;
            _this.disablePictures = true;
            _this.errorsSubmit = {};
            let formData = new FormData();
            
            if (_this.activeGallery == "Memories") {
                if (_this.galleryMemory.length > 0) {
                    Array.from(_this.galleryMemory).forEach((file) => {
                        formData.append('galleryMemory[]', file);
                    });
                    axios.post(route('host.memoryUpload', _this.host), formData)
                        .then((response) => {
                            if (response.data.success) {
                                _this.allMemories = response.data.memories;
                                _this.galleryMemory = [];
                                _this.uploadMultiMessage = null;
                                _this.$toastr.success(response.data.message || 'Memories uploaded successfully');
                            } else {
                                _this.$toastr.error(response.data.message || 'Failed to upload memories');
                            }
                        })
                        .catch((error) => {
                            _this.disablePictures = false;
                            console.error('Upload error:', error.response?.data);
                            
                            if (error.response?.data?.errors) {
                                _this.errorsSubmit = {
                                    galleryMemory: Object.values(error.response.data.errors)[0]
                                };
                                _this.$toastr.error('Please check the form for errors');
                            } else {
                                _this.$toastr.error(error.response?.data?.message || 'An error occurred while uploading memories');
                            }
                        })
                        .finally(() => {
                            _this.disablePictures = false;
                        });
                }
            }
            else if (this.activeGallery == "Albums") {
                formData.append("album", this.albumName);
                let images = null;
                if (this.uploadMultiImage.length > 0) {
                    images = [...this.uploadMultiImage];
                    images.forEach(function (item, index) {
                        formData.append("galleryImage[" + index + "]", item);
                    });
                }
                axios.post(route("addAlbum", this.host), formData)
                    .then((response) => {
                        this.allAlbums = response.data[0];
                        this.allGalleries = response.data[1];
                        this.uploadMultiImage = [];
                        this.uploadMultiMessage = null;
                        this.message = "Album created successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch((error) => {
                        this.disablePictures = false;
                        if (error.response?.data?.errors) {
                            this.errorsSubmit = {
                                galleryImage: Object.values(error.response.data.errors)[0]
                            };
                            this.$toastr.error('Please check the form for errors');
                        } else {
                            this.$toastr.error(error.response?.data?.message || 'An error occurred while creating album');
                        }
                    });
            }
            else if (this.activeGallery == "Videos") {
                let images = null;
                if (this.uploadMultiImage.length > 0) {
                    images = [...this.uploadMultiImage];
                    images.forEach(function (item, index) {
                        formData.append("galleryVideo[" + index + "]", item);
                    });
                }
                axios.post(route("hostvideoUpload", this.host), formData)
                    .then((response) => {
                        this.allVideos = response.data[2];
                        this.uploadMultiImage = [];
                        this.uploadMultiMessage = null;
                        this.message = "Videos uploaded successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch((error) => {
                        this.disablePictures = false;
                        if (error.response?.data?.errors) {
                            this.errorsSubmit = {
                                galleryVideo: Object.values(error.response.data.errors)[0]
                            };
                            this.$toastr.error('Please check the form for errors');
                        } else {
                            this.$toastr.error(error.response?.data?.message || 'An error occurred while uploading videos');
                        }
                    });
            }
            else if (this.activeGallery == "Pictures") {
                let images = null;
                if (this.uploadMultiImage.length > 0) {
                    images = [...this.uploadMultiImage];
                    images.forEach(function (item, index) {
                        formData.append("galleryPicture[" + index + "]", item);
                    });
                }
                axios.post(route("host.pictureUpload", this.host), formData)
                    .then((response) => {
                        this.allPictures = response.data[1];
                        this.uploadMultiImage = [];
                        this.uploadMultiMessage = null;
                        this.message = "Pictures uploaded successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch((error) => {
                        this.disablePictures = false;
                        if (error.response?.data?.errors) {
                            this.errorsSubmit = {
                                galleryPicture: Object.values(error.response.data.errors)[0]
                            };
                            this.$toastr.error('Please check the form for errors');
                        } else {
                            this.$toastr.error(error.response?.data?.message || 'An error occurred while uploading pictures');
                        }
                    });
            }
        },
        deleteImage(id) {
            if(confirm('Are you sure you want to delete this image?')) {
                axios.delete(route('hostgallery.destroy', [this.host, id]))
                    .then(response => {
                        this.allGalleries = this.allGalleries.filter(item => item.id !== id);
                        this.message = "Image deleted successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch(error => {
                        this.message = "Error deleting image";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    });
            }
        },
        deleteAlbum(id) {
            if(confirm('Are you sure you want to delete this album?')) {
                axios.delete(route('deleteAlbum', [this.host, id]))
                    .then(response => {
                        this.allAlbums = this.allAlbums.filter(item => item.id !== id);
                        this.message = "Album deleted successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch(error => {
                        this.message = "Error deleting album";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    });
            }
        },
        deleteVideo(videoId) {
            if (confirm("Are you sure you want to delete this video?")) {
                axios
                    .delete(route("host.deleteVideo", [this.host, videoId]))
                    .then(response => {
                        this.allVideos = this.allVideos.filter(video => video.id !== videoId);
                        this.message = "Video deleted successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error deleting video:', error);
                        this.message = "Error deleting video";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    });
            }
        },
        deletePicture(pictureId) {
            if (confirm("Are you sure you want to delete this picture?")) {
                axios
                    .delete(route("host.deletePicture", [this.host, pictureId]))
                    .then(response => {
                        this.allPictures = this.allPictures.filter(picture => picture.id !== pictureId);
                        this.message = "Picture deleted successfully!";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error deleting picture:', error);
                        this.message = "Error deleting picture";
                        setTimeout(() => {
                            this.message = null;
                        }, 3000);
                    });
            }
        },
        deleteMemory(memoryId) {
            if (confirm('Are you sure you want to delete this memory?')) {
                axios.delete(route('host.deleteMemory', [this.host, memoryId]))
                    .then(() => {
                        this.allMemories = this.allMemories.filter(memory => memory.id !== memoryId);
                        this.$toastr.success('Memory deleted successfully');
                    })
                    .catch((error) => {
                        this.$toastr.error('Error deleting memory');
                        console.error('Delete error:', error);
                    });
            }
        },
        deleteAlbumItem(itemId) {
            if (confirm('Are you sure you want to delete this item?')) {
                axios.delete(route('host.deleteAlbumItem', [this.host, itemId]))
                    .then(() => {
                        this.clickedAlbum = this.clickedAlbum.filter(item => item.id !== itemId);
                        this.$toastr.success('Item deleted successfully');
                    })
                    .catch((error) => {
                        this.$toastr.error('Error deleting item');
                        console.error('Delete error:', error);
                    });
            }
        }
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
.album-cont,
.video-cont {
    position: relative;
    padding-top: 100%;
    border-radius: 20px;
}
.img-cont > img,
.img-cont > video,
.album-cont > img,
.video-player {
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
.delete-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1000;
}
.delete-btn button {
    padding: 5px 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.8);
    border: none;
    cursor: pointer;
}
.delete-btn button:hover {
    background: rgba(255, 255, 255, 0.9);
}
.video-name {
    position: absolute;
    bottom: 10px;
    left: 10px;
    color: white;
    font-size: 14px;
    z-index: 1000;
    background: rgba(0, 0, 0, 0.5);
    padding: 5px 10px;
    border-radius: 5px;
}
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
.album-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 1rem;
    padding: 1rem;
}

.album-header {
    padding: 1rem;
    border-bottom: 1px solid #eee;
}

.album-cover-video,
.album-video {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 20px;
    z-index: 99;
}

.album-video {
    object-fit: contain;
    background: #000;
}
</style>
