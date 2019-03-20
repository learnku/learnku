/**
 * 请不要删除 init 方法， 否在外面拿不到 upload 实例
 */
 /* ```````````````````````````````````````````````````````````````````````````
 
<!-- 上传图片盒子 -->
<div id="uploader-avatar">
    <!-- 上传文件相关 -->
    <div class="queueList">
        <div class="placeholder">
            <!-- 上传图片按钮 -->
            <div id="filePicker"></div>
        </div>
    </div>
    <!-- 状态栏 -->
    <div class="statusBar" style="display:none;">
        <div class="progress">
            <span class="text">0%</span>
            <span class="percentage"></span>
        </div><div class="info"></div>
        <div class="btns">
            <div id="filePicker2">继续添加</div><div class="uploadBtn">开始上传</div>
        </div>
    </div>
</div>


@section('script')
<script type="text/javascript">
    var avatar = new MyWebUpload({
        wrapDom: '#uploader-avatar'
    });
    let uploader = avatar.init();

    // 添加“添加文件”的按钮【 单张图则不需要 】
    uploader.addButton({
        id: '#filePicker2',
        label: '继续添加'
    });
</script>
@endsection
``````````````````````````````````````````````````````````````````````````` */

class MyWebUpload{
    constructor(setting){
        if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {
            alert( 'Web Uploader 不支持您的浏览器！');
        } else if (!WebUploader.Uploader.support()) {
            alert( 'Web Uploader 不支持您的浏览器！');
        }

        this.setting = {
            wrapDom: '#uploader',
            server: Config.routes.upload_image || '/api/images',
            // 提交的额外数据
            formData: {},
            // 指定选择文件的按钮容器，不指定则不创建按钮
            pick: {
                id: '#filePicker',
                label: '点击选择图片'
            },
            // 指定Drag And Drop拖拽的容器，如果不指定，则不启动
            // dnd: '',

            // 指定监听 paste 事件的容器，如果不指定，不启用此功能。此功能为通过粘贴来添加截屏的图片。建议设置为 document.body
            // paste: '',

            // 指定接受哪些类型的文件
            accept: {
                title: 'Images',
                extensions: 'gif,jpg,jpeg,bmp,png',
                mimeTypes: 'image/*'
            },
            // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
            disableGlobalDnd: true,
            // 限制图片数量
            fileNumLimit: 1,    
            // 总大小限制
            fileSizeLimit: 2 * 1024 * 1024,         
            // 单图片大小限制
            fileSingleSizeLimit: 2 * 1024 * 1024    
        }

        // 配置文件
        this.setting = Object.assign({}, this.setting, setting)
        // 实例对象
        this.uploader = null;

        this.$wrap = $(this.setting.wrapDom);
        // 图片容器
        this.$queue = $( '<ul class="filelist"></ul>' ).appendTo( this.$wrap.find( '.queueList' ) );
        // 没选择文件之前的内容。
        this.$placeHolder = this.$wrap.find( '.placeholder' );
        // 状态栏，包括进度和控制按钮
        this.$statusBar = this.$wrap.find( '.statusBar' );
        // 进度
        this.$progress = this.$statusBar.find( '.progress' ).hide();
        // 文件总体选择信息。
        this.$info = this.$statusBar.find( '.info' );
        // 上传按钮
        this.$upload = this.$wrap.find( '.uploadBtn' );
        // 添加的文件数量
        this.fileCount = 0;
        // 添加的文件总大小
        this.fileSize = 0;

        // 优化retina, 在retina下这个值是2
        this.ratio = window.devicePixelRatio || 1;
        // 缩略图大小
        this.thumbnailWidth = 110 * this.ratio;
        this.thumbnailHeight = 110 * this.ratio;

        // 可能有pedding, ready, uploading, confirm, done.
        this.state = 'pedding';

        // 所有文件的进度信息，key为file id
        this.percentages = {};
    }

    // 初始化
    init(){
        let self = this;
        // 实例化
        this.uploader = WebUploader.create(self.setting);

        // 文件准备完成
        this.uploader.onFileQueued = function( file ) {
            self.fileCount++;
            self.fileSize += file.size;

            if ( self.fileCount === 1 ) {
                self.$placeHolder.addClass( 'element-invisible' );
                self.$statusBar.show();
            }

            self.addFile( file );
            self.setState( 'ready' );
            self.updateTotalProgress();
        };
        this.uploader.onFileDequeued = function( file ) {
            self.fileCount--;
            self.fileSize -= file.size;

            if ( !self.fileCount ) {
                self.setState( 'pedding' );
            }

            self.removeFile( file );
            self.updateTotalProgress();
        };

        this.uploader.onError = function( code ) {
            alert( 'Eroor: ' + code );
        };

        this.uploader.on( 'all', function( type ) {
            var stats;
            switch( type ) {
                case 'uploadFinished':
                    self.setState( 'confirm' );
                    break;

                case 'startUpload':
                    self.setState( 'uploading' );
                    break;

                case 'stopUpload':
                    self.setState( 'paused' );
                    break;

            }
        });

        // 返回实例对象
        return this.uploader;
    }

    addFile(file){
        let self = this;
        var $li = $( '<li id="' + file.id + '">' +
            '<p class="title">' + file.name + '</p>' +
            '<p class="imgWrap"></p>'+
            '<p class="progress"><span></span></p>' +
            '</li>' ),

            $btns = $('<div class="file-panel">' +
                '<span class="cancel">删除</span>').appendTo( $li ),
            $prgress = $li.find('p.progress span'),
            $wrap = $li.find( 'p.imgWrap' ),
            $info = $('<p class="error"></p>'),

            showError = function( code ) {
                switch( code ) {
                    case 'exceed_size':
                        text = '文件大小超出';
                        break;

                    case 'interrupt':
                        text = '上传暂停';
                        break;

                    default:
                        text = '上传失败，请重试';
                        break;
                }

                $info.text( text ).appendTo( $li );
            };

        if ( file.getStatus() === 'invalid' ) {
            showError( file.statusText );
        } else {
            // @todo lazyload
            $wrap.text( '预览中' );
            self.uploader.makeThumb( file, function( error, src ) {
                var img;

                if ( error ) {
                    $wrap.text( '不能预览' );
                    return;
                }

                if( self.isSupportBase64 ) {
                    img = $('<img src="'+src+'">');
                    $wrap.empty().append( img );
                } else {
                    $.ajax('../../server/preview.php', {
                        method: 'POST',
                        data: src,
                        dataType:'json'
                    }).done(function( response ) {
                        if (response.result) {
                            img = $('<img src="'+response.result+'">');
                            $wrap.empty().append( img );
                        } else {
                            $wrap.text("预览出错");
                        }
                    });
                }
            }, self.thumbnailWidth, self.thumbnailHeight );

            self.percentages[ file.id ] = [ file.size, 0 ];
            file.rotation = 0;
        }

        file.on('statuschange', function( cur, prev ) {
            if ( prev === 'progress' ) {
                $prgress.hide().width(0);
            } else if ( prev === 'queued' ) {
                $li.off( 'mouseenter mouseleave' );
                $btns.remove();
            }

            // 成功
            if ( cur === 'error' || cur === 'invalid' ) {
                console.log( file.statusText );
                showError( file.statusText );
                self.percentages[ file.id ][ 1 ] = 1;
            } else if ( cur === 'interrupt' ) {
                showError( 'interrupt' );
            } else if ( cur === 'queued' ) {
                $info.remove();
                $prgress.css('display', 'block');
                self.percentages[ file.id ][ 1 ] = 0;
            } else if ( cur === 'progress' ) {
                $info.remove();
                $prgress.css('display', 'block');
            } else if ( cur === 'complete' ) {
                $prgress.hide().width(0);
                $li.append( '<span class="success"></span>' );
            }

            $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
        });

        // 鼠标进入
        $li.on( 'mouseenter', function() {
            $btns.stop().animate({height: 30});
        });

        // 鼠标离开
        $li.on( 'mouseleave', function() {
            $btns.stop().animate({height: 0});
        });

        // 预览上按钮点击事件
        $btns.on( 'click', 'span', function() {
            var index = $(this).index(),
                deg;

            switch ( index ) {
                case 0:
                    self.uploader.removeFile( file );
                    return;
            }

            if ( supportTransition ) {
                deg = 'rotate(' + file.rotation + 'deg)';
                $wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
            }
        });

        $li.appendTo( self.$queue );
    }

    // 负责view的销毁
    removeFile( file ) {
        var $li = $('#'+file.id);

        delete this.percentages[ file.id ];
        this.updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    // 更新总进度
    updateTotalProgress() {
        let self = this;
        var loaded = 0,
            total = 0,
            spans = this.$progress.children(),
            percent;

        $.each( this.percentages, function( k, v ) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        } );

        percent = total ? loaded / total : 0;


        spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
        spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
        this.updateStatus();
    }

    setState( val ) {
        let self = this;
        var file, stats;

        if ( val === self.state ) {
            return;
        }

        this.$upload.removeClass( 'state-' + self.state );
        this.$upload.addClass( 'state-' + val );
        self.state = val;

        switch ( self.state ) {
            case 'pedding':
                self.$placeHolder.removeClass( 'element-invisible' );
                self.$queue.parent().removeClass('filled');
                self.$queue.hide();
                self.$statusBar.addClass( 'element-invisible' );
                self.uploader.refresh();
                break;

            case 'ready':
                self.$placeHolder.addClass( 'element-invisible' );
                $( '#filePicker2' ).removeClass( 'element-invisible');
                self.$queue.parent().addClass('filled');
                self.$queue.show();
                self.$statusBar.removeClass('element-invisible');
                self.uploader.refresh();
                break;

            case 'uploading':
                $( '#filePicker2' ).addClass( 'element-invisible' );
                self.$progress.show();
                self.$progress.show();
                self.$upload.text( '暂停上传' );
                break;

            case 'paused':
                self.$progress.show();
                self.$upload.text( '继续上传' );
                break;

            case 'confirm':
                self.$progress.hide();
                $( '#filePicker2' ).removeClass( 'element-invisible' );
                self.$upload.text( '开始上传' );

                stats = self.uploader.getStats();
                if ( stats.successNum && !stats.uploadFailNum ) {
                    self.setState( 'finish' );
                    return;
                }
                break;
            case 'finish':
                stats = self.uploader.getStats();
                if ( stats.successNum ) {
                    alert( '上传成功' );
                } else {
                    // 没有成功的图片，重设
                    self.state = 'done';
                    location.reload();
                }
                break;
        }

        self.updateStatus();
    }

    updateStatus(){
        var text = '', stats;

        if ( this.state === 'ready' ) {
            text = '选中' + this.fileCount + '张图片，共' +
                WebUploader.formatSize( this.fileSize ) + '。';
        } else if ( this.state === 'confirm' ) {
            stats = this.uploader.getStats();
            if ( stats.uploadFailNum ) {
                text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                    stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
            }

        } else {
            stats = this.uploader.getStats();
            text = '共' + this.fileCount + '张（' +
                WebUploader.formatSize( this.fileSize )  +
                '），已上传' + stats.successNum + '张';

            if ( stats.uploadFailNum ) {
                text += '，失败' + stats.uploadFailNum + '张';
            }
        }

        this.$info.html( text );
    }

    // 判断浏览器是否支持图片的base64
    isSupportBase64 (){
        var data = new Image();
        var support = true;
        data.onload = data.onerror = function() {
            if( this.width != 1 || this.height != 1 ) {
                support = false;
            }
        }
        data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
        return support;
    }
}

window.MyWebUpload = MyWebUpload;