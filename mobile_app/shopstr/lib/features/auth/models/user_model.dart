class UserModel {
  final String status;
  final String message;
  final String? token;

  UserModel({
    required this.status,
    required this.message,
    this.token,
  });

  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      status: json['status'],
      message: json['message'],
      token: json['data'] != null ? json['data']['token'] : null,
    );
  }
}