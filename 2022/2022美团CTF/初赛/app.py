import os
import re
from hashlib import md5
from flask import Flask, redirect, request, render_template, url_for, make_response

app=Flask(__name__)

def extractFile(filepath):
    extractdir=filepath.split('.')[0]
    if not os.path.exists(extractdir):
        os.makedirs(extractdir)
    os.system(f'unzip -o {filepath} -d {extractdir}')
    return redirect(url_for('display',extractdir=extractdir))

@app.route('/', methods=['GET'])
def index():
    return render_template('index.html')

@app.route('/display', methods=['GET'])
@app.route('/display/', methods=['GET'])
@app.route('/display/<path:extractdir>', methods=['GET'])
def display(extractdir=''):
    if re.search(r"\.\.", extractdir, re.M | re.I) != None:
        return "Hacker?"
    else:
        if not os.path.exists(extractdir):
            return make_response("error", 404)
        else:
            if not os.path.isdir(extractdir):
                f = open(extractdir, 'rb')
                response = make_response(f.read())
                response.headers['Content-Type'] = 'application/octet-stream'
                return response
            else:
                fn = os.listdir(extractdir)
                fn = [".."] + fn
                f = open("templates/template.html")
                x = f.read()
                f.close()
                ret = "<h1>文件列表:</h1><br><hr>"
                for i in fn:
                    tpath = os.path.join('/display', extractdir, i)
                    ret += "<a href='" + tpath + "'>" + i + "</a><br>"
                x = x.replace("HTMLTEXT", ret)
                return x


@app.route('/upload', methods=['GET', 'POST'])
def upload():
    ip = request.remote_addr
    uploadpath = 'uploads/' + md5(ip.encode()).hexdigest()[0:4]

    if not os.path.exists(uploadpath):
        os.makedirs(uploadpath)

    if request.method == 'GET':
        return redirect('/')

    if request.method == 'POST':
        try:
            upFile = request.files['file']
            print(upFile.filename)
            if os.path.splitext(upFile.filename)[-1]=='.zip':
                filepath=f"{uploadpath}/{md5(upFile.filename.encode()).hexdigest()[0:4]}.zip"
                upFile.save(filepath)
                zipDatas = extractFile(filepath)
                return zipDatas
            else:
                return f"{upFile.filename} is not a zip file !"
        except:
            return make_response("error", 404)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8000, debug=True)