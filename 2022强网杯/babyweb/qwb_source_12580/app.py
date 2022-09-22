@app.route("/buy", methods=['POST'])
def buy():
    if not session:
        return redirect('/login')
    elif session['user'] != 'admin':
        return "you are not admin"
    else :
        result = {}
        data = request.get_json()
        product = data["product"]
        for i in product:
            if not isinstance(i["id"],int) or not isinstance(i["num"],int):
                return "not int"
            if i["id"] not in (1,2):
                return "id error"
            if i["num"] not in (0,1,2,3,4,5):
                return "num error"
            result[i["id"]] = i["num"]
        sql = "select money,flag,hint from qwb where username='admin'"
        conn = sqlite3.connect('/root/py/test.db')
        c = conn.cursor()
        cursor = c.execute(sql)
        for row in cursor:
            if len(row):
                money = row[0]
                flag = row[1]
                hint = row[2]
        data = b'{"secret":"xxxx","money":' + str(money).encode() + b',' + request.get_data()[1:] #secret已打码
        r = requests.post("http://127.0.0.1:10002/pay",data).text
        r = json.loads(r)
        if r["error"] != 0:
            return r["error"]
        money = int(r["money"])
        hint = hint + result[1]
        flag = flag + result[2]
        sql = "update qwb set money={},hint={},flag={} where username='admin'".format(money,hint,flag)
        conn = sqlite3.connect('/root/py/test.db')
        c = conn.cursor()
        try:
            c.execute(sql)
            conn.commit()
        except Exception as e:
            conn.rollback()
            c.close()
            conn.close()
            return "database error"
        return "success"