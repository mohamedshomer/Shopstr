import 'package:flutter/material.dart';
import 'package:fl_chart/fl_chart.dart'; // Chart package
import 'package:get/get.dart';
import 'package:shopstr/features/dashboard/controllers/dashboard_controller.dart';
import '../../../core/widgets/sidebar.dart';
import '../../../core/api/api_service.dart';
import '../../../core/constants/api_routes.dart';

class DashboardScreen extends StatefulWidget {
  const DashboardScreen({super.key});

  @override
  State<DashboardScreen> createState() => _DashboardScreenState();
}

class _DashboardScreenState extends State<DashboardScreen> {
  final controller = Get.put(DashboardController());
  String currentPage = "Dashboard";
  bool isLoading = true;

  int totalProducts = 0;
  int totalCategories = 0;
  int totalCustomers = 0;

  List<Map<String, dynamic>> recentInvoices = [];
  List<FlSpot> salesData = [];

  final api = ApiService();

  @override
  void initState() {
    super.initState();
    fetchStats();
  }

  Future<void> fetchStats() async {
    setState(() {
      isLoading = true;
    });

    try {
      final products = await api.get(ApiRoutes.getProducts);
      final categories = await api.get(ApiRoutes.getCategories);
      final customers = await api.get(ApiRoutes.getCustomers);
      final invoices = await api.get(ApiRoutes.getInvoices);

      // حساب إجمالي المبيعات لكل يوم (مثال)
      Map<String, double> salesByDay = {};
      for (var inv in invoices['data'] ?? []) {
        String date = inv['created_at'].substring(0, 10);
        double total = double.tryParse(inv['total'].toString()) ?? 0;
        salesByDay[date] = (salesByDay[date] ?? 0) + total;
      }

      // تحويل البيانات للـ Chart
      List<FlSpot> chartData = [];
      int x = 0;
      for (var entry in salesByDay.entries) {
        chartData.add(FlSpot(x.toDouble(), entry.value));
        x++;
      }

      setState(() {
        totalProducts = products['data']?.length ?? 0;
        totalCategories = categories['data']?.length ?? 0;
        totalCustomers = customers['data']?.length ?? 0;
        recentInvoices = invoices['data']?.take(5).toList() ?? [];
        salesData = chartData;
        isLoading = false;
      });
    } catch (e) {
      setState(() {
        isLoading = false;
      });
      print("Error fetching stats: $e");
    }
  }

  Widget statCard(String title, int count, Color color) {
    return Card(
      color: color,
      child: Container(
        width: 150,
        height: 100,
        padding: EdgeInsets.all(16),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Text(
              "$count",
              style: TextStyle(
                fontSize: 28,
                color: Colors.white,
                fontWeight: FontWeight.bold,
              ),
            ),
            SizedBox(height: 8),
            Text(title, style: TextStyle(color: Colors.white)),
          ],
        ),
      ),
    );
  }

  Widget recentInvoicesTable() {
    return Card(
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          children: [
            Text(
              "Recent Invoices",
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 16),
            SingleChildScrollView(
              scrollDirection: Axis.horizontal,
              child: DataTable(
                columns: [
                  DataColumn(label: Text("ID")),
                  DataColumn(label: Text("Customer")),
                  DataColumn(label: Text("Total")),
                  DataColumn(label: Text("Date")),
                ],
                rows: recentInvoices.map((inv) {
                  return DataRow(
                    cells: [
                      DataCell(Text(inv['id'].toString())),
                      DataCell(Text(inv['customer_name'] ?? 'N/A')),
                      DataCell(Text(inv['total'].toString())),
                      DataCell(Text(inv['created_at'].substring(0, 10))),
                    ],
                  );
                }).toList(),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget salesChart() {
    if (salesData.isEmpty) return SizedBox.shrink();

    return Card(
      child: Padding(
        padding: EdgeInsets.all(16),
        child: Column(
          children: [
            Text(
              "Sales Chart",
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            SizedBox(height: 16),
            SizedBox(
              height: 200,
              child: LineChart(
                LineChartData(
                  lineBarsData: [
                    LineChartBarData(
                      spots: salesData,
                      isCurved: true,
                      color: Colors.blue,
                      barWidth: 3,
                      dotData: FlDotData(show: false),
                    ),
                  ],
                  titlesData: FlTitlesData(
                    bottomTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: false),
                    ),
                    leftTitles: AxisTitles(
                      sideTitles: SideTitles(showTitles: true),
                    ),
                  ),
                  gridData: FlGridData(show: true),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Row(
        children: [
          Sidebar(
            onSelect: (page) {
              setState(() {
                currentPage = page;
              });
            },
          ),

          Expanded(
            child: isLoading
                ? Center(child: CircularProgressIndicator())
                : Padding(
                    padding: const EdgeInsets.all(16.0),
                    child: SingleChildScrollView(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            currentPage,
                            style: TextStyle(
                              fontSize: 32,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          SizedBox(height: 20),
                          Wrap(
                            spacing: 16,
                            runSpacing: 16,
                            children: [
                              Obx(
                                () => statCard(
                                  "Products",
                                  controller.products.value,
                                  Colors.blue,
                                ),
                              ),
                              Obx(
                                () => statCard(
                                  "Categories",
                                  controller.categories.value,
                                  Colors.green,
                                ),
                              ),
                              Obx(
                                () => statCard(
                                  "Customers",
                                  controller.customers.value,
                                  Colors.orange,
                                ),
                              ),
                            ],
                          ),
                          SizedBox(height: 30),
                          recentInvoicesTable(),
                          SizedBox(height: 30),
                          salesChart(),
                        ],
                      ),
                    ),
                  ),
          ),
        ],
      ),
    );
  }
}
