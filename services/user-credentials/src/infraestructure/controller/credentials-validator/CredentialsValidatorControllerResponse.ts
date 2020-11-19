export type CredentialsValidatorControllerResponse = {
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
