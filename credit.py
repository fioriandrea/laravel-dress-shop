#!/usr/bin/env python
import json
from http.server import BaseHTTPRequestHandler, HTTPServer


# Creiamo la classe che riceverà e risponderà alla richieste HTTP

class testHTTPServer_RequestHandler(BaseHTTPRequestHandler):
    # Implementiamo il metodo che risponde alle richieste GET
    def do_GET(self):
        # Specifichiamo il codice di risposta
        self.send_response(200)
        # Specifichiamo uno o più header
        self.send_header('Content-type', 'application/json')
        self.end_headers()
        cardNumber = int(self.path[7:].encode())

        if checkCreditCard(cardNumber):
            self.wfile.write((json.dumps({'result': 'positive'})).encode())
        else:
            self.wfile.write((json.dumps({'result': 'negative'})).encode())
        return


cardNumbers = [1234_5678_9000_0000, 2345_6789_1000_0000, 3456_7891_2000_0000]


def checkCreditCard(cardNumber):
    if cardNumber in cardNumbers:
        return True
    return False


def main():
    address = '127.0.0.1'
    port = 8081
    print('Avvio del server su http://{}:{}'.format(address, port))
    server_address = (address, port)
    httpd = HTTPServer(server_address, testHTTPServer_RequestHandler)
    print('Server in esecuzione...')
    httpd.serve_forever()


if __name__ == '__main__':
    main()
