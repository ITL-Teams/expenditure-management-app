export type UserRegisterControllerResponse = {
  success?: {
    user_id: string
    message: string
  }
  error?: {
    message: string
    reason: string
  }
}
