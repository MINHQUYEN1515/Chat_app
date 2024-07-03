import 'package:firebase_messaging/firebase_messaging.dart';

class FireBaseService {
  final _firebaseMessage = FirebaseMessaging.instance;
  Future<void> initFireBase() async {
    _firebaseMessage.requestPermission();
    final token = await _firebaseMessage.getToken();
    print(token);
  }
}
