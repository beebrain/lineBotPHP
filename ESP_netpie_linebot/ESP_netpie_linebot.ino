// Coding By IOXhop : http://www.ioxhop.com/

#include <ESP8266WiFi.h>
#include <PubSubClient.h>

// Update these with values suitable for your network.
const char* ssid = "beebrain";
const char* password = "1234554321";

// Config MQTT Server
#define mqtt_server "m16.cloudmqtt.com"
#define mqtt_port 17089
#define mqtt_user "bee"
#define mqtt_password "great1234"


WiFiClient espClient;
PubSubClient client(espClient);

void setup() {
  pinMode(LED_BUILTIN, OUTPUT);

  Serial.begin(115200);
  delay(10);

  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);

  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());

  client.setServer(mqtt_server, mqtt_port);
  client.setCallback(callback);
}

void loop() {
  if (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    if (client.connect("ESP8266Client", mqtt_user, mqtt_password)) {
      Serial.println("connected");
      client.subscribe("/gate/");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000);
      return;
    }
  }
  client.loop();
}

void callback(char* topic, byte* payload, unsigned int length) {
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");
  String msg = "";
  int i = 0;
  while (i < length) msg += (char)payload[i++];
  if (msg == "GET") {
    client.publish("/gate/", (digitalRead(LED_BUILTIN) ? "CLOSE" : "OPEN"));
    Serial.println("Send !");
    return;
  } else if (msg == "OPEN") {

    digitalWrite(LED_BUILTIN, (msg == "OPEN" ? LOW : HIGH));

  } else {
    digitalWrite(LED_BUILTIN, (msg == "CLOSE" ? HIGH : LOW));
  }

  Serial.println(msg);
}
