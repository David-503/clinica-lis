import DashboardLayout from "../pages/Layout/DashboardLayout.vue";

import Dashboard from "../pages/Dashboard.vue";
import UserProfile from "../pages/UserProfile.vue";
import FormPacientes from "../pages/Pacientes/Form.vue";
import ListPacientes from "../pages/Pacientes/List.vue";
import FormDoctores from "../pages/Doctor/Form.vue";
import ListDoctores from "../pages/Doctor/List.vue";
import FormSecretarias from "../pages/Secretaria/Form.vue";
import ListSecretarias from "../pages/Secretaria/List.vue";
import FormPromotor from "../pages/Promotor/Form.vue";
import ListPromotor from "../pages/Promotor/List.vue";
import ConsultasDoctor from "../pages/Doctor/Consultas.vue";
import CitasPaciente from "../pages/Pacientes/Citas.vue";
import CitasDoctor from "../pages/Doctor/Citas.vue";
import TableList from "../pages/TableList.vue";
import Typography from "../pages/Typography.vue";
import Icons from "../pages/Icons.vue";
import Maps from "../pages/Maps.vue";
import Notifications from "../pages/Notifications.vue";
import UpgradeToPRO from "../pages/UpgradeToPRO.vue";
import AppointmentsForm from "../pages/Secretary/AppointmentsForm.vue";
import FileForm from "../pages/Secretary/FileForm.vue";

const routes = [
  {
    path: "/",
    component: DashboardLayout,
    redirect: "/dashboard",
    children: [
      {
        path: "/dashboard",
        name: "Dashboard",
        component: Dashboard
      },
      {
        path: "/dashboard/citas",
        name: "Citas Medicas",
        component: AppointmentsForm
      },
      {
        path: "/dashboard/paciente/:dui/expediente",
        name: "Expediente",
        component: FileForm
      },
      {
        path: "/dashboard/paciente/crear",
        name: "Agregar Paciente",
        component: FormPacientes
      },
      {
        path: "/dashboard/paciente/edit/:dui",
        name: "Editar Paciente",
        component: FormPacientes
      },
      {
        path: "/dashboard/paciente",
        name: "Pacientes",
        component: ListPacientes
      },
      {
        path: "/dashboard/doctor/crear",
        name: "Agregar Doctor",
        component: FormDoctores
      },
      {
        path: "/dashboard/doctor/edit/:dui",
        name: "Editar Doctor",
        component: FormDoctores
      },
      {
        path: "/dashboard/doctor/citas",
        name: "Proximas Citas",
        component: CitasDoctor
      },
      {
        path: "/dashboard/doctor",
        name: "Doctores",
        component: ListDoctores
      },
      {
        path: "/dashboard/secretaria/crear",
        name: "Agregar Secretaria",
        component: FormSecretarias
      },
      {
        path: "/dashboard/secretaria/edit/:dui",
        name: "Editar Secretaria",
        component: FormSecretarias
      },
      {
        path: "/dashboard/secretaria",
        name: "Secretarias",
        component: ListSecretarias
      },
      {
        path: "/dashboard/promotor/crear",
        name: "Agregar promotor",
        component: FormPromotor
      },
      {
        path: "/dashboard/promotor/edit/:dui",
        name: "Editar Promotor",
        component: FormPromotor
      },
      {
        path: "/dashboard/promotor",
        name: "Promotores",
        component: ListPromotor
      },
      {
        path: "/dashboard/paciente/citas",
        name: "Mis Citas",
        component: CitasPaciente
      },
      {
        path: "/dashboard/consultas/:dui?",
        name: "Realizar Consulta",
        component: ConsultasDoctor
      },
      {
        path: "icons",
        name: "Icons",
        component: Icons
      },
      {
        path: "maps",
        name: "Maps",
        meta: {
          hideFooter: true
        },
        component: Maps
      },
      {
        path: "notifications",
        name: "Notifications",
        component: Notifications
      },
      {
        path: "upgrade",
        name: "Upgrade to PRO",
        component: UpgradeToPRO
      }
    ]
  }
];

export default routes;
