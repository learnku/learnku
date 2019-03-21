class MyUploadOne {
    constructor(setting = {}){
        // 默认值
        this.setting = Object.assign({}, {

        }, setting);

        this.init();
    }

    init(){
        let self = this;
        (async function getImage () {
            const {value: file} = await Swal.fire({
                title: 'Select image',
                input: 'file',
                inputAttributes: {
                    'name': 'image',
                    'accept': 'image/*',
                    'aria-label': 'Upload your profile picture'
                }
            });

            if (file) {
                self.handleInputChange(file);
                /*const reader = new FileReader
                reader.onload = (e) => {
                    Swal.fire({
                        title: 'Your uploaded picture',
                        imageUrl: e.target.result,
                        imageAlt: 'The uploaded picture'
                    })
                };
                reader.readAsDataURL(file)*/
            }

        })()
    }

    handleInputChange(file){
        // 获取当前选中的文件
        // const file = event.target.files[0];

        let imgMasSize = 1024 * 1024 * 2; // 2MB

        // 检查文件类型
        if(['jpeg', 'png', 'gif', 'jpg'].indexOf(file.type.split("/")[1]) < 0){
            // 自定义报错方式
            // Toast.error("文件类型仅支持 jpeg/png/gif！", 2000, undefined, false);
            return;
        }

        // 文件大小限制
        if(file.size > imgMasSize ) {
            // 文件大小自定义限制
            // Toast.error("文件大小不能超过10MB！", 2000, undefined, false);
            return;
        }

        this.transformFileToFormData(file);
    }

    // 将File append进 FormData
    transformFileToFormData(file){
        let formData = new FormData();
        // 自定义formData中的内容
        // type
        formData.append('type', file.type);
        // size
        formData.append('size', file.size || "image/jpeg");
        // name
        formData.append('name', file.name);
        // lastModifiedDate
        formData.append('lastModifiedDate', file.lastModifiedDate);
        // append 文件
        formData.append('image', file);

        formData.append('image_type', 'avatar');
        // 上传图片
        this.uploadImg(formData);
    }

    // 上传图片
    uploadImg(formData){
        axios({
            url: Config.routes.upload_image,
            method: 'POST',
            data: formData
        }).then((res)=> {
            console.log(res)
        })
    }
}

window.MyUploadOne = MyUploadOne;
