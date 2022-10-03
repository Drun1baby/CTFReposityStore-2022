
from bottle import route, run, template, request, response, error
import os
import re


@route("/")
def home():
    return template("index")


@route("/show")
def index():
    response.content_type = "text/plain; charset=UTF-8"
    param = request.query.id
    if re.search("^../app", param):
        return "No!!!!"
    requested_path = os.path.join(os.getcwd() + "/poems", param)
    try:
        with open(requested_path) as f:
            tfile = f.read()
    except Exception as e:
        return "No This Poems"
    return tfile


@error(404)
def error404(error):
    return template("error")


@route("/sign")
def index():
    try:
        session = request.get_cookie("name", secret='Se3333KKKKKKAAAAIIIIILLLLovVVVVV3333YYYYoooouuu')
        if not session or session["name"] == "guest":
            session = {"name": "admin"}
            response.set_cookie("name", session, secret='Se3333KKKKKKAAAAIIIIILLLLovVVVVV3333YYYYoooouuu')
            return template("guest", name=session["name"])
        if session["name"] == "admin":
            return template("admin", name=session["name"])
    except:
        return "pls no hax"


if __name__ == "__main__":
    os.chdir(os.path.dirname(__file__))
    run(host="127.0.0.1", port=8081)
