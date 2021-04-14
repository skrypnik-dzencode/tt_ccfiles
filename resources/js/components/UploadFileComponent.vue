<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload file</div>
                    <div class="card-body">
                        Here you can upload files: json | xml | csv
                    </div>
                    <div class="card-body" v-show="showSuccessMessage">
                        <p>File <strong>{{ filename }}</strong> downloaded!</p>
                    </div>
                    <div class="card-body" v-for="(errors, type) in responseErrors">
                        <p class="alert-danger" v-for="error in errors">Field <strong>{{ type }} :</strong> {{ error }}
                        </p>
                    </div>
                    <div class="card-body" v-show="fileList.length">Uploaded Files
                        <div class="justify-content-around mb-1 row align-items-center" v-for="file in fileList">
                            <div>File <b>{{ file.filename }}</b></div>
                            <button class="btn btn-secondary" @click="getFileContent(file)">Edit as plain text</button>
                            <button class="btn btn-secondary" @click="getFileItems(file)">Edit as entities</button>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Download as
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <button v-for="fileType in fileTypes" class="dropdown-item"
                                            @click="downloadFileAs(file,fileType)" type="button">
                                        {{ fileType }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <input @change="setFile" ref="fileupload" type="file">
                    </div>
                    <textarea v-model="fileContent" v-show="showFileContent" cols="30" @focusout="storeFileContent"
                              rows="10">{{ fileContent }}</textarea>

                    <table class="table" v-show="showFileItems">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" v-for="key in itemKeys">{{ key }}</th>
                            <th scope="col">edit</th>
                            <th scope="col">delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, ind) in fileItems" v-model="fileItems">
                            <th scope="row">{{ (ind + 1) }}</th>
                            <td v-for="key in itemKeys">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroup-sizing-sm">{{ item[key] }}</span>
                                    </div>
                                    <input type="text" v-if="item.isEditable" class="form-control"
                                           v-model="item[key]" aria-label="Small"
                                           aria-describedby="inputGroup-sizing-sm">
                                </div>
                            </td>
                            <th scope="row" v-if="!item.isEditable">
                                <button @click="editItem(item)" class="btn btn-warning">edit</button>
                            </th>
                            <th scope="row" v-else>
                                <button @click="editFileItem(item,ind)" class="btn btn-info">update</button>
                            </th>
                            <th scope="row">
                                <button @click="removeItem(item)" class="btn btn-danger">delete</button>
                            </th>
                        </tr>
                        <tr v-if="fileItems.length" v-model="fileItems">
                            <td :colspan="itemKeys.length + 3" class="text-center">
                                <button @click="addNewItem()" class="btn btn-success">Add New Item</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'fileTypes',
    ],
    data: function () {
        return {
            file: null,
            filename: '',
            filepath: '',
            fileContent: '',
            showSuccessMessage: false,
            showErrorMessage: false,
            showFileContent: false,
            showFileItems: false,
            fileList: [],
            responseErrors: [],
            fileItems: [],
            itemKeys: [],
        }
    },
    mounted() {
        this.getFileList()
        Array.prototype.remove = function () {
            let what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };
    },
    methods: {
        setFile: function (event) {
            this.file = event.target.files[0];
            this.uploadFile();
        },
        uploadFile: function () {
            let formData = new FormData()
            formData.append('file', this.file)
            axios.post('api/upload-file', formData).then((response) => {
                this.showSuccessMessage = true;
                this.filename = response.data.filename
                this.filepath = response.data.filepath
                this.getFileList()
                this.clear()
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
                this.clear()
            });
        },
        clear: function () {
            this.file = null;
            this.$refs.fileupload.value = null
        },
        getFileContent: function (file) {
            this.showFileContent = true;
            this.showFileItems = false;
            axios.get('api/get-file-content', {params: {path: file.filepath}}).then((response) => {
                this.fileContent = response.data.fileContent;
                this.filename = file.filename
                this.filepath = file.filepath
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        storeFileContent: function () {
            let formData = new FormData();
            formData.append('path', this.filepath)
            formData.append('fileContent', this.fileContent)
            axios.post('api/store-file-content', formData)
                .then((response) => {
                    this.fileContent = response.data.fileContent;
                }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        getFileList: function () {
            axios.get('api/get-file-list').then((response) => {
                this.fileList = response.data
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        getFileItems: function (file) {
            this.showFileContent = false;
            this.showFileItems = true;
            axios.get('api/get-file-items', {params: {path: file.filepath}}).then((response) => {
                this.itemKeys = Object.keys(Object.assign({}, ...response.data))
                this.fileItems = response.data
                this.filename = file.filename
                this.filepath = file.filepath
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        downloadFileAs(file, extension) {
            axios({
                url: 'api/download-file',
                method: 'GET',
                responseType: 'blob',
                params: {
                    filepath: file.filepath,
                    extension: extension,
                }
            }).then((response) => {
                let fileURL = window.URL.createObjectURL(new Blob([response.data]));
                let fileLink = document.createElement('a');
                let fileName = file.filename.substr(0, file.filename.lastIndexOf(".")) + "." + extension;
                fileLink.href = fileURL;
                fileLink.setAttribute('download', fileName);
                document.body.appendChild(fileLink);
                fileLink.click();
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        removeItem: function (item) {
            axios({
                url: 'api/remove-file-item',
                method: 'DELETE',
                params: {
                    filepath: this.filepath,
                    item: item,
                }
            }).then((response) => {
                if (response.data) {
                    this.fileItems.remove(item)
                }
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        editItem: function (item) {
            this.fileItems.forEach((item) => {
                this.$set(item, 'isEditable', false)
            })
            this.$set(item, 'isEditable', true)
        },
        addNewItem: function () {
            axios({
                url: 'api/add-file-item',
                method: 'POST',
                responseType: 'blob',
                params: {
                    filepath: this.filepath,
                }
            }).then((response) => {
                this.getFileItems({
                    filepath: this.filepath,
                    filename: this.filename
                })
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        },
        editFileItem: function (item, ind) {
            this.fileItems.forEach((item) => {
                this.$delete(item, 'isEditable')
            })
            axios({
                url: 'api/update-file-item',
                method: 'PATCH',
                params: {
                    filepath: this.filepath,
                    item: item,
                    index: ind,
                }
            }).then((response) => {
                this.getFileItems({
                    filepath: this.filepath,
                    filename: this.filename
                })
            }).catch((error) => {
                console.log(error.response.data)
                this.responseErrors = error.response.data.errors
            });
        }
    }
}
</script>
