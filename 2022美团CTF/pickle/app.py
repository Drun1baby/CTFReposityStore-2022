import base64
import pickle
from flask import Flask, session
import os
import random

app = Flask(__name__)
app.config['SECRET_KEY'] = os.urandom(2).hex()

@app.route('/')
def hello_world():
    if not session.get('user'):
        session['user'] = ''.join(random.choices("admin", k=5))
    return 'Hello {}!'.format(session['user'])


@app.route('/admin')
def admin():
    if session.get('user') != "admin":
        return f"<script>alert('Access Denied');window.location.href='/'</script>"
    else:
        try:
            a = base64.b64decode(session.get('ser_data')).replace(b"builtin", b"BuIltIn").replace(b"os", b"Os").replace(b"bytes", b"Bytes")
            if b'R' in a or b'i' in a or b'o' in a or b'b' in a:
                raise pickle.UnpicklingError("R i o b is forbidden")
            pickle.loads(base64.b64decode(session.get('ser_data')))
            return "ok"
        except:
            return "error!"


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=8888)
