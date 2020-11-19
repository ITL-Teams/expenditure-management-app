export type TwoFactorValidatorControllerResponse = {
  success?: {
    status: string
    user_id?: string
    enterprise_account?: boolean
  }
  error?: {
    message: string
    reason: string
  }
}
